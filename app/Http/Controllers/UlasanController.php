<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Store a new ulasan for an order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'content' => 'required|string|min:5',
        ], [
            'content.required' => 'Ulasan tidak boleh kosong',
            'content.min' => 'Ulasan minimal 5 karakter'
        ]);

        // Check if order belongs to the authenticated user
        $order = Order::findOrFail($request->order_id);
        if ($order->user_id != Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk memberikan ulasan pada pesanan ini'
            ], 403);
        }

        // Check if review already exists for this order
        if ($order->review) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan ulasan untuk pesanan ini'
            ], 400);
        }

        // Create review
        $review = Review::create([
            'order_id' => $request->order_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas ulasan Anda!',
            'review' => $review
        ]);
    }

    /**
     * Display a listing of ulasan (for admin)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check for admin permission if needed

        $reviews = Review::with(['user', 'order'])->latest()->paginate(10);

        return view('admin.ulasan.index', compact('reviews'));
    }

    /**
     * Delete an ulasan (for admin)
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        // Check for admin permission if needed

        $review->delete();

        return redirect()->route('admin.ulasan.index')
            ->with('success', 'Ulasan berhasil dihapus');
    }

    /**
     * Show form for guest to submit review
     * 
     * @return \Illuminate\Http\Response
     */
    public function showGuestForm()
    {
        return view('ulasan.guest-form');
    }

    /**
     * Submit a review as a guest
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitGuestReview(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'content' => 'required|string|min:5',
        ], [
            'content.required' => 'Ulasan tidak boleh kosong',
            'content.min' => 'Ulasan minimal 5 karakter'
        ]);

        // Check if order exists
        $order = Order::findOrFail($request->order_id);

        // Check if review already exists for this order
        if ($order->review) {
            return back()->with('error', 'Pesanan ini sudah memiliki ulasan');
        }

        // Create review
        $review = Review::create([
            'order_id' => $request->order_id,
            'user_id' => $order->user_id,
            'content' => $request->content,
        ]);

        return redirect()->route('ulasan.success')->with('success', 'Terima kasih atas ulasan Anda!');
    }

    /**
     * Legacy method for backwards compatibility
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGuestReview(Request $request)
    {
        return $this->submitGuestReview($request);
    }

    /**
     * Show success page after submitting review
     * 
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        return view('ulasan.success');
    }
}
