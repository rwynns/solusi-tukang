<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for current user
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        // Ensure user can only see their own orders
        if ($order->user_id !== Auth::id() && Auth::user()->role_id !== 1) {
            abort(403);
        }

        return view('orders.show', [
            'order' => $order->load(['items.tukangProfile', 'items.subJasa', 'paymentOption', 'payment'])
        ]);
    }

    /**
     * Cancel an order
     */
    public function cancel(Order $order)
    {
        // Ensure user can only cancel their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only pending orders can be cancelled
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pesanan dengan status menunggu yang dapat dibatalkan');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibatalkan');
    }

    /**
     * Admin: Display all orders
     */
    public function adminIndex(Request $request)
    {
        $query = Order::with(['user', 'payment']);

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status if provided
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.orders.index', [
            'orders' => $orders,
            'statusFilter' => $request->status,
            'paymentStatusFilter' => $request->payment_status
        ]);
    }

    /**
     * Admin: Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Status pesanan berhasil diperbarui');
    }

    /**
     * Admin: Update payment status
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,verifying,paid,cancelled'
        ]);
        try {
            // Begin transaction
            DB::beginTransaction();

            // Update order payment status
            $order->payment_status = $request->payment_status;
            $order->save();

            // Update payment record if exists
            if ($order->payment) {
                // Mapping dari order payment_status ke payment status
                $paymentStatusMap = [
                    'pending' => 'pending',
                    'verifying' => 'pending', // masih pending di tabel payment
                    'paid' => 'verified',
                    'cancelled' => 'rejected'
                ];

                $order->payment->status = $paymentStatusMap[$request->payment_status];
                $order->payment->save();
            }

            // If payment is confirmed as paid, automatically update order status to processing
            if ($request->payment_status === 'paid' && $order->status === 'pending') {
                $order->status = 'processing';
                $order->save();
            }

            DB::commit();

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Status pembayaran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Admin: View specific order
     */
    public function adminShow(Order $order)
    {
        $order = Order::with(['orderItems.tukangProfile.user', 'user', 'payment', 'paymentOption'])
            ->findOrFail($order->id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Admin: Assign technician to order item
     */
    public function assignTechnician(Request $request, Order $order)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'tukang_profile_id' => 'required|exists:tukang_profiles,id'
        ]);

        // Get the order item
        $orderItem = $order->items()->findOrFail($request->order_item_id);

        // Assign technician
        $orderItem->tukang_profile_id = $request->tukang_profile_id;
        $orderItem->save();

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Teknisi berhasil ditugaskan');
    }

    public function verifyPayment(Order $order)
    {
        try {
            // Begin transaction
            DB::beginTransaction();

            // Update order payment status
            $order->payment_status = 'paid';
            $order->save();

            // Update payment record if exists
            if ($order->payment) {
                $order->payment->status = 'verified';
                $order->payment->verified_at = now();
                $order->payment->save();
            }

            // If order is still pending, update to processing
            if ($order->status === 'pending') {
                $order->status = 'processing';
                $order->save();
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Pembayaran berhasil diverifikasi');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function tukangOrderIndex()
    {
        // Ambil profil tukang dari user yang login
        $tukangProfile = Auth::user()->tukangProfile;

        if (!$tukangProfile) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil tukang tidak ditemukan');
        }

        // Ambil order_id yang memiliki item dengan tukang_profile_id yang sesuai
        $orderIds = DB::table('order_items')
            ->where('tukang_profile_id', $tukangProfile->id)
            ->select('order_id')
            ->distinct()
            ->get()
            ->pluck('order_id')
            ->toArray();

        // Ambil pesanan berdasarkan ID yang sudah difilter
        $orders = Order::whereIn('id', $orderIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tukang.orders.index', compact('orders'));
    }

    public function tukangOrderShow(Order $order)
    {
        $tukangProfile = Auth::user()->tukangProfile;

        if (!$tukangProfile) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil tukang tidak ditemukan');
        }

        // Cek apakah tukang ditugaskan untuk pesanan ini
        $isAssigned = DB::table('order_items')
            ->where('order_id', $order->id)
            ->where('tukang_profile_id', $tukangProfile->id)
            ->exists();

        if (!$isAssigned) {
            return redirect()->route('tukang.orders.index')
                ->with('error', 'Anda tidak memiliki akses ke pesanan ini');
        }

        // Load relasi yang dibutuhkan
        $order->load(['orderItems.tukangProfile.user', 'user', 'payment', 'paymentOption']);

        return view('tukang.orders.show', compact('order'));
    }
}
