<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\SubJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index(): View
    {
        if (Auth::check()) {
            // For logged in users, get cart from database
            $cartItems = Cart::with(['subJasa.jasa', 'subJasa.kategori'])
                ->forUser(Auth::id())
                ->get();

            $cartTotal = Cart::getCartTotal(Auth::id());
            $cartCount = Cart::getCartCount(Auth::id());

            // Transform for view compatibility
            $cart = $cartItems->map(function ($item) {
                return [
                    'id' => $item->sub_jasa_id,
                    'name' => $item->subJasa->nama,
                    'price' => $item->price,
                    'image' => $item->subJasa->gambar ? asset('storage/' . $item->subJasa->gambar) : null,
                    'quantity' => $item->quantity,
                    'satuan' => $item->subJasa->satuan
                ];
            })->toArray();
        } else {
            // For guests, still use cookies
            $cart = json_decode(request()->cookie('cart'), true) ?? [];
        }

        return view('checkout.cart', [
            'cart' => $cart
        ]);
    }

    /**
     * Add item to cart via AJAX
     */
    public function addItem(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:sub_jasa,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if (Auth::check()) {
            // For logged in users, save to database
            try {
                $subJasa = SubJasa::findOrFail($request->id);

                $cart = Cart::addToCart(
                    Auth::id(),
                    $request->id,
                    $request->quantity,
                    $subJasa->harga
                );

                $cartCount = Cart::getCartCount(Auth::id());
                $cartTotal = Cart::getCartTotal(Auth::id());

                return response()->json([
                    'success' => true,
                    'message' => 'Layanan berhasil ditambahkan ke keranjang',
                    'cart_count' => $cartCount,
                    'cart_total' => $cartTotal,
                    'formatted_total' => 'Rp ' . number_format($cartTotal, 0, ',', '.')
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan item ke keranjang'
                ], 500);
            }
        } else {
            // For guests, still use cookies
            $subJasa = SubJasa::findOrFail($request->id);
            $cart = json_decode($request->cookie('cart'), true) ?? [];

            // Check if item already exists in cart
            $existingItemIndex = collect($cart)->search(function ($item) use ($request) {
                return $item['id'] == $request->id;
            });

            if ($existingItemIndex !== false) {
                // Update quantity
                $cart[$existingItemIndex]['quantity'] += $request->quantity;
            } else {
                // Add new item
                $cart[] = [
                    'id' => $subJasa->id,
                    'name' => $subJasa->nama,
                    'price' => $subJasa->harga,
                    'image' => $subJasa->gambar ? asset('storage/' . $subJasa->gambar) : null,
                    'quantity' => $request->quantity,
                    'satuan' => $subJasa->satuan
                ];
            }

            $cookie = Cookie::make('cart', json_encode($cart), 60 * 24 * 7); // 1 week

            return response()->json([
                'success' => true,
                'message' => 'Layanan berhasil ditambahkan ke keranjang',
                'cart' => $cart
            ])->withCookie($cookie);
        }
    }

    /**
     * Update item quantity
     */
    public function updateItem(Request $request): JsonResponse
    {
        if (Auth::check()) {
            // For logged in users, update database
            $request->validate([
                'sub_jasa_id' => 'required|exists:sub_jasa,id',
                'quantity' => 'required|integer|min:0'
            ]);

            try {
                $cart = Cart::updateQuantity(Auth::id(), $request->sub_jasa_id, $request->quantity);

                $cartCount = Cart::getCartCount(Auth::id());
                $cartTotal = Cart::getCartTotal(Auth::id());

                if ($cart) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Jumlah layanan berhasil diperbarui',
                        'cart_count' => $cartCount,
                        'cart_total' => $cartTotal,
                        'formatted_total' => 'Rp ' . number_format($cartTotal, 0, ',', '.')
                    ]);
                } else {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item berhasil dihapus dari keranjang',
                        'cart_count' => $cartCount,
                        'cart_total' => $cartTotal,
                        'formatted_total' => 'Rp ' . number_format($cartTotal, 0, ',', '.'),
                        'removed' => true
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui jumlah item'
                ], 500);
            }
        } else {
            // For guests, use cookie method
            $request->validate([
                'index' => 'required|integer|min:0',
                'quantity' => 'required|integer|min:1'
            ]);

            $cart = json_decode($request->cookie('cart'), true) ?? [];

            if (isset($cart[$request->index])) {
                $cart[$request->index]['quantity'] = $request->quantity;
                $cookie = Cookie::make('cart', json_encode($cart), 60 * 24 * 7);

                return response()->json([
                    'success' => true,
                    'message' => 'Jumlah layanan berhasil diperbarui',
                    'cart' => $cart
                ])->withCookie($cookie);
            }

            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang'
            ], 404);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeItem(Request $request): JsonResponse
    {
        if (Auth::check()) {
            // For logged in users, remove from database
            $request->validate([
                'sub_jasa_id' => 'required|exists:sub_jasa,id'
            ]);

            try {
                Cart::removeFromCart(Auth::id(), $request->sub_jasa_id);

                $cartCount = Cart::getCartCount(Auth::id());
                $cartTotal = Cart::getCartTotal(Auth::id());

                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil dihapus dari keranjang',
                    'cart_count' => $cartCount,
                    'cart_total' => $cartTotal,
                    'formatted_total' => 'Rp ' . number_format($cartTotal, 0, ',', '.')
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus item dari keranjang'
                ], 500);
            }
        } else {
            // For guests, use cookie method
            $request->validate([
                'index' => 'required|integer|min:0'
            ]);

            $cart = json_decode($request->cookie('cart'), true) ?? [];

            if (isset($cart[$request->index])) {
                array_splice($cart, $request->index, 1);
                $cookie = Cookie::make('cart', json_encode($cart), 60 * 24 * 7);

                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil dihapus dari keranjang',
                    'cart' => $cart
                ])->withCookie($cookie);
            }

            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang'
            ], 404);
        }
    }

    /**
     * Clear cart
     */
    public function clear(): JsonResponse
    {
        if (Auth::check()) {
            // For logged in users, clear database cart
            try {
                Cart::clearCart(Auth::id());

                return response()->json([
                    'success' => true,
                    'message' => 'Keranjang berhasil dikosongkan',
                    'cart_count' => 0,
                    'cart_total' => 0,
                    'formatted_total' => 'Rp 0'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengosongkan keranjang'
                ], 500);
            }
        } else {
            // For guests, clear cookie
            $cookie = Cookie::make('cart', json_encode([]), 60 * 24 * 7);

            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil dikosongkan'
            ])->withCookie($cookie);
        }
    }

    /**
     * Get cart data for AJAX requests
     */
    public function getData(): JsonResponse
    {
        try {
            if (Auth::check()) {
                $cartItems = Cart::with(['subJasa.jasa'])
                    ->forUser(Auth::id())
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'sub_jasa_id' => $item->sub_jasa_id,
                            'name' => $item->subJasa->nama ?? 'Unknown Service',
                            'service' => $item->subJasa->jasa->nama ?? 'Unknown Category',
                            'price' => (float) $item->price,
                            'quantity' => $item->quantity,
                            'total_price' => $item->total_price,
                            'formatted_price' => 'Rp ' . number_format($item->price, 0, ',', '.'),
                            'formatted_total_price' => 'Rp ' . number_format($item->total_price, 0, ',', '.'),
                            'satuan' => $item->subJasa->satuan ?? 'unit',
                            'image' => $item->subJasa->gambar ? asset('storage/' . $item->subJasa->gambar) : '/images/login-bg.png'
                        ];
                    });

                $cartCount = Cart::getCartCount(Auth::id());
                $cartTotal = Cart::getCartTotal(Auth::id());

                return response()->json([
                    'success' => true,
                    'items' => $cartItems,
                    'count' => $cartCount,
                    'total' => $cartTotal,
                    'formatted_total' => 'Rp ' . number_format($cartTotal, 0, ',', '.')
                ]);
            } else {
                $cart = json_decode(request()->cookie('cart'), true) ?? [];
                $total = collect($cart)->sum(function ($item) {
                    return $item['price'] * $item['quantity'];
                });

                return response()->json([
                    'success' => true,
                    'items' => $cart,
                    'count' => collect($cart)->sum('quantity'),
                    'total' => $total,
                    'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.')
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Cart getData error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving cart data: ' . $e->getMessage(),
                'items' => [],
                'count' => 0,
                'total' => 0,
                'formatted_total' => 'Rp 0'
            ], 500);
        }
    }

    /**
     * Get cart count for navbar
     */
    public function getCount(): JsonResponse
    {
        if (Auth::check()) {
            $count = Cart::getCartCount(Auth::id());
        } else {
            $cart = json_decode(request()->cookie('cart'), true) ?? [];
            $count = collect($cart)->sum('quantity');
        }

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Migrate guest cart to user cart when user logs in
     */
    public function migrateGuestCart(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User must be logged in'
            ], 401);
        }

        $guestCart = json_decode($request->cookie('cart'), true) ?? [];

        if (empty($guestCart)) {
            return response()->json([
                'success' => true,
                'message' => 'No items to migrate'
            ]);
        }

        try {
            foreach ($guestCart as $item) {
                if (isset($item['id'], $item['quantity'], $item['price'])) {
                    Cart::addToCart(
                        Auth::id(),
                        $item['id'],
                        $item['quantity'],
                        $item['price']
                    );
                }
            }

            // Clear the guest cart cookie
            $cookie = Cookie::make('cart', json_encode([]), 60 * 24 * 7);

            $cartCount = Cart::getCartCount(Auth::id());
            $cartTotal = Cart::getCartTotal(Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Cart berhasil dimigrasikan',
                'cart_count' => $cartCount,
                'cart_total' => $cartTotal,
                'formatted_total' => 'Rp ' . number_format($cartTotal, 0, ',', '.')
            ])->withCookie($cookie);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal migrasi cart'
            ], 500);
        }
    }

    /**
     * Sync cart data between localStorage and server (for backward compatibility)
     */
    public function syncCart(Request $request): JsonResponse
    {
        if (Auth::check()) {
            // For logged users, this method is not needed as we use database
            return response()->json([
                'success' => true,
                'message' => 'Cart sync tidak diperlukan untuk user yang login'
            ]);
        }

        $cart = $request->input('cart');

        // Validasi data
        if (!is_array($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Format cart tidak valid'
            ], 400);
        }

        // Set cookie dengan data cart terbaru
        $cookie = Cookie::make('cart', json_encode($cart), 60 * 24 * 7); // 1 week

        return response()->json([
            'success' => true,
            'message' => 'Cart berhasil disinkronkan'
        ])->withCookie($cookie);
    }

    /**
     * Get cart data from server (for backward compatibility)
     */
    public function getCart(): JsonResponse
    {
        if (Auth::check()) {
            // Return database cart data
            return $this->getData();
        } else {
            // Return cookie cart data
            $cart = json_decode(request()->cookie('cart'), true) ?? [];

            return response()->json([
                'success' => true,
                'cart' => $cart
            ]);
        }
    }
}
