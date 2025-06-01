<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubJasa;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    /**
     * Display cart contents
     */
    public function index()
    {
        $cart = json_decode(request()->cookie('cart'), true) ?? [];

        return view('checkout.cart', [
            'cart' => $cart
        ]);
    }

    /**
     * Add item to cart via AJAX
     */
    public function addItem(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sub_jasa,id',
            'quantity' => 'required|integer|min:1'
        ]);

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

    /**
     * Update item quantity
     */
    public function updateItem(Request $request)
    {
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

    /**
     * Remove item from cart
     */
    public function removeItem(Request $request)
    {
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

    /**
     * Clear cart
     */
    public function clear()
    {
        $cookie = Cookie::make('cart', json_encode([]), 60 * 24 * 7);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ])->withCookie($cookie);
    }

    /**
     * Sync cart data between localStorage and server cookie
     */
    public function syncCart(Request $request)
    {
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
     * Get cart data from server cookie
     */
    public function getCart()
    {
        $cart = json_decode(request()->cookie('cart'), true) ?? [];

        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }
}
