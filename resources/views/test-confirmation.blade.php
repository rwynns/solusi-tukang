@extends('layouts.main')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6">Test Order Confirmation System</h1>

        @if ($orders->count() > 0)
            <div class="grid gap-6">
                @foreach ($orders as $order)
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-xl font-semibold mb-4">Order #{{ $order->order_number }}</h3>

                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <strong>Customer:</strong> {{ $order->customer_name }}<br>
                                <strong>Status:</strong> {{ $order->status }}<br>
                                <strong>Payment Status:</strong> {{ $order->payment_status }}<br>
                                <strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </div>
                            <div>
                                <strong>Konfirmasi Customer:</strong>
                                @if ($order->customer_confirmed)
                                    <span class="text-green-600">✓ Sudah</span>
                                    <small class="text-gray-500">({{ $order->customer_confirmed_at }})</small>
                                @else
                                    <span class="text-red-600">✗ Belum</span>
                                @endif
                                <br>

                                <strong>Konfirmasi Tukang:</strong>
                                @if ($order->tukang_confirmed)
                                    <span class="text-green-600">✓ Sudah</span>
                                    <small class="text-gray-500">({{ $order->tukang_confirmed_at }})</small>
                                @else
                                    <span class="text-red-600">✗ Belum</span>
                                @endif
                                <br>

                                <strong>Earning Split:</strong>
                                @if ($order->earningSplit()->exists())
                                    <span class="text-green-600">✓ Sudah dibuat</span>
                                    <small class="text-gray-500">({{ $order->earningSplit->count() }} split)</small>
                                @else
                                    <span class="text-yellow-600">○ Belum dibuat</span>
                                    @if ($order->status === 'completed')
                                        <small class="text-red-500">(Error: pesanan completed tapi belum ada split)</small>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('customer.orders.show', $order) }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                View as Customer
                            </a>
                            <a href="{{ route('tukang.pesanan.show', $order) }}"
                                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                View as Tukang
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                <strong>Info:</strong> Tidak ada pesanan dengan status processing dan payment paid untuk testing.
            </div>
        @endif
    </div>
@endsection
