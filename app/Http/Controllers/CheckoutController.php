<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentOption;
use App\Models\TukangProfile;
use App\Models\SubJasa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Start checkout process - review cart
     */
    public function index(Request $request)
    {
        // Get cart data directly
        $cartController = new \App\Http\Controllers\CartController();
        $cartData = $cartController->getCartData($request);

        // Debug cart data
        Log::info('Cart Data:', ['data' => $cartData]);

        // If cart is empty, redirect
        if (!$cartData || empty($cartData)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }

        // Transform for view compatibility
        $cart = collect($cartData)->map(function ($item) {
            $result = [
                'id' => $item['sub_jasa_id'] ?? $item['id'],
                'name' => $item['name'],
                'price' => (float)$item['price'], // Ensure price is a number
                'image' => $item['image'],
                'quantity' => $item['quantity'],
                'satuan' => $item['satuan'] ?? null
            ];

            // Debug transformed item
            Log::info('Transformed Item:', ['item' => $result]);

            return $result;
        })->toArray();

        return view('checkout.review', [
            'cart' => $cart,
            'currentStep' => 1
        ]);
    }

    /**
     * Select technicians for services
     */
    public function selectTechnicians(Request $request)
    {
        // Get cart data directly
        $cartController = new \App\Http\Controllers\CartController();
        $cartData = $cartController->getCartData($request);

        if (!$cartData || empty($cartData)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }

        // Transform for view compatibility
        $cart = collect($cartData)->map(function ($item) {
            return [
                'id' => $item['sub_jasa_id'] ?? $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'image' => $item['image'],
                'quantity' => $item['quantity'],
                'satuan' => $item['satuan'] ?? null
            ];
        })->toArray();

        // Get available technicians for each service
        $availableTechnicians = [];

        foreach ($cart as $item) {
            $subJasaId = $item['id'];

            // Find technicians with this skill
            $technicians = TukangProfile::whereHas('skills', function ($query) use ($subJasaId) {
                $query->where('sub_jasa_id', $subJasaId);
            })
                ->with(['user', 'location', 'skills'])
                ->get();

            $availableTechnicians[$subJasaId] = $technicians;
        }

        return view('checkout.pilih-teknisi', [
            'cart' => $cart,
            'availableTechnicians' => $availableTechnicians,
            'currentStep' => 2
        ]);
    }

    /**
     * Save selected technicians
     */
    public function saveTechnicians(Request $request)
    {
        $selectedTechnicians = $request->input('technician');

        if (empty($selectedTechnicians)) {
            return redirect()->back()->with('error', 'Harap pilih teknisi untuk setiap layanan');
        }

        // Store selections in session
        foreach ($selectedTechnicians as $itemIndex => $tukangId) {
            session()->put("selected_technicians.$itemIndex", $tukangId);
        }

        return redirect()->route('checkout.delivery');
    }

    /**
     * Enter delivery information
     */
    public function deliveryInfo()
    {
        $user = Auth::user();

        return view('checkout.delivery', [
            'user' => $user,
            'currentStep' => 3
        ]);
    }

    /**
     * Save delivery information
     */
    public function saveDeliveryInfo(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'customer_address' => 'required|string',  // Validasi customer_address
            'notes' => 'nullable|string'
        ]);

        // Store in session - PERBAIKAN: Ubah 'address' menjadi 'customer_address'
        session()->put('checkout.delivery', [
            'name' => $request->name,
            'phone' => $request->phone,
            'customer_address' => $request->customer_address,  // Kunci yang benar
            'notes' => $request->notes
        ]);

        return redirect()->route('checkout.payment');
    }

    /**
     * Choose payment method
     */
    public function paymentMethod(Request $request)
    {
        try {
            // Get cart data using CartController for consistency
            $cartController = new \App\Http\Controllers\CartController();
            $cartData = $cartController->getCartData($request);

            // Debug cart data
            Log::info('Payment Method - Cart Data:', ['data' => $cartData]);

            // If cart is empty, redirect
            if (!$cartData || empty($cartData)) {
                Log::warning('Payment Method - Empty cart, redirecting to cart index');
                return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
            }

            // Ensure $cartData is an array or collection
            if (!is_array($cartData) && !($cartData instanceof \Illuminate\Support\Collection)) {
                Log::error('Payment Method - Invalid cart data type:', ['type' => gettype($cartData)]);
                return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan dengan data keranjang');
            }

            // Transform for view compatibility
            $cart = collect($cartData)->map(function ($item) {
                $transformedItem = [
                    'id' => $item['sub_jasa_id'] ?? $item['id'],
                    'name' => $item['name'],
                    'price' => (float)($item['price'] ?? 0), // Add null check
                    'image' => $item['image'] ?? null,
                    'quantity' => $item['quantity'] ?? 1,
                    'satuan' => $item['satuan'] ?? 'pcs'
                ];

                Log::info('Payment Method - Transformed Item:', ['item' => $transformedItem]);
                return $transformedItem;
            });

            // Calculate total
            $total = $cart->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            Log::info('Payment Method - Final Data:', [
                'cart_count' => $cart->count(),
                'total' => $total
            ]);

            $paymentOptions = PaymentOption::where('is_active', true)->get();

            // Generate temporary order number for display
            $tempOrderNumber = 'ST-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
            session(['temp_order_number' => $tempOrderNumber]);

            return view('checkout.payment', [
                'paymentOptions' => $paymentOptions,
                'cart' => $cart->toArray(), // Convert collection to array for view
                'total' => $total,
                'tempOrderNumber' => $tempOrderNumber,
                'currentStep' => 4
            ]);
        } catch (\Exception $e) {
            Log::error('Payment Method Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('cart.index')
                ->with('error', 'Terjadi kesalahan saat memproses halaman pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Process checkout and create order
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'payment_option_id' => 'required|exists:payment_options,id',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi bukti transfer
            'payment_notes' => 'nullable|string|max:500' // Validasi catatan pembayaran
        ]);

        // Get cart data using CartController for consistency
        $cartController = new \App\Http\Controllers\CartController();
        $cartData = $cartController->getCartData($request);

        if (!$cartData || empty($cartData)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }

        $cart = $cartData;
        $selectedTechnicians = session('selected_technicians');
        $deliveryInfo = session('checkout.delivery'); // Also fixed: You forgot to get this from session

        if (empty($cart) || empty($deliveryInfo) || empty($selectedTechnicians)) {
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan dalam proses checkout');
        }

        try {
            DB::beginTransaction();

            // Calculate total
            $total = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => (new Order())->generateOrderNumber(),
                'total_amount' => $total,
                'payment_option_id' => $request->payment_option_id,
                'customer_name' => $deliveryInfo['name'],
                'customer_phone' => $deliveryInfo['phone'],
                'customer_address' => $deliveryInfo['customer_address'],
                'notes' => $deliveryInfo['notes'] ?? null
            ]);

            // Create order items with assigned technicians
            foreach ($cart as $index => $item) {
                $tukangProfileId = $selectedTechnicians[$index] ?? null;

                OrderItem::create([
                    'order_id' => $order->id,
                    'sub_jasa_id' => $item['sub_jasa_id'],
                    'tukang_profile_id' => $tukangProfileId,
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);
            }

            // Upload bukti pembayaran dan atur status ke "verifying"
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

                // Set order payment status ke "verifying" karena bukti sudah diupload
                $order->payment_status = 'verifying';
                $order->save();
            }

            // Initialize payment record with bukti transfer
            Payment::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'status' => 'pending', // status di tabel Payment
                'payment_proof' => $paymentProofPath,
                'customer_notes' => $request->payment_notes
            ]);

            DB::commit();

            // Clear cart for both authenticated and guest users
            if (Auth::check()) {
                // Clear database cart for authenticated users
                \App\Models\Cart::forUser(Auth::id())->delete();
            }

            // Clear cookie/localStorage cart
            Cookie::queue(Cookie::forget('cart'));
            session()->forget(['checkout.delivery', 'selected_technicians']);

            return redirect()->route('checkout.success', ['order' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show success page
     */
    public function success(Order $order)
    {
        // Ensure user can only see their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', [
            'order' => $order->load(['items.tukangProfile', 'paymentOption'])
        ]);
    }
}
