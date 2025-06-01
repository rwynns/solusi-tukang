<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Show payment page
     */
    public function show(Order $order)
    {
        // Ensure user can only access their own payments
        if ($order->user_id !== Auth::id() && Auth::user()->role_id !== 1) {
            abort(403);
        }

        // Check if payment is needed
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Pembayaran untuk pesanan ini telah dikonfirmasi');
        }

        return view('payments.show', [
            'order' => $order->load(['payment', 'paymentOption'])
        ]);
    }

    /**
     * Upload payment proof
     */
    public function uploadProof(Request $request, Order $order)
    {
        // Ensure user can only upload for their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|max:2048'
        ]);

        // Store the image
        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        // Update payment record
        $payment = Payment::where('order_id', $order->id)->firstOrFail();
        $payment->payment_proof = $path;
        $payment->status = 'pending'; // Set to pending for verification
        $payment->save();

        // Update order payment status
        $order->payment_status = 'verifying';
        $order->save();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Bukti pembayaran berhasil diunggah dan sedang diverifikasi');
    }

    /**
     * Admin: List payments needing verification
     */
    public function adminIndex()
    {
        $pendingPayments = Payment::with(['order', 'user'])
            ->where('status', 'pending')
            ->whereNotNull('payment_proof')
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('admin.payments.index', [
            'payments' => $pendingPayments
        ]);
    }

    /**
     * Admin: Show payment verification page
     */
    public function adminShow(Payment $payment)
    {
        return view('admin.payments.show', [
            'payment' => $payment->load(['order.items', 'order.paymentOption', 'user'])
        ]);
    }

    /**
     * Admin: Verify payment
     */
    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        // Update payment
        $payment->status = $request->status;
        $payment->admin_notes = $request->admin_notes;

        if ($request->status === 'verified') {
            $payment->verified_at = now();

            // Update order payment status
            $payment->order->payment_status = 'paid';

            // If order is still pending, move to processing
            if ($payment->order->status === 'pending') {
                $payment->order->status = 'processing';
            }

            $payment->order->save();
        } else {
            // Rejected - update order payment status
            $payment->order->payment_status = 'unpaid';
            $payment->order->save();
        }

        $payment->save();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil ' . ($request->status === 'verified' ? 'diverifikasi' : 'ditolak'));
    }
}
