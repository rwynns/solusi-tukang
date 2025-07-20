@extends('layouts.main')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6">Test Earning Distribution Timing</h1>

        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
            <strong>Info:</strong> Earning splits sekarang hanya dibuat ketika pesanan status = 'completed' (bukan saat
            payment = 'paid')
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Completed Orders -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-green-600">Pesanan Selesai (Should Have Earnings)</h2>

                @if ($completedOrders->count() > 0)
                    @foreach ($completedOrders as $order)
                        <div class="border-b pb-3 mb-3 last:border-b-0">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <strong>Order #{{ $order->order_number }}</strong><br>
                                    <small class="text-gray-500">{{ $order->customer_name }}</small>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm">Status: <span
                                            class="text-green-600 font-semibold">{{ $order->status }}</span></div>
                                    <div class="text-sm">Payment: <span
                                            class="text-green-600 font-semibold">{{ $order->payment_status }}</span></div>
                                </div>
                            </div>

                            <div class="text-sm">
                                <strong>Earning Splits:</strong>
                                @if ($order->earningSplit && $order->earningSplit->count() > 0)
                                    <span class="text-green-600">✓ {{ $order->earningSplit->count() }} split(s)</span>
                                    <br>
                                    @foreach ($order->earningSplit as $split)
                                        <div class="ml-4 text-xs text-gray-600">
                                            - {{ $split->tukang->name }}: Rp
                                            {{ number_format($split->tukang_amount, 0, ',', '.') }}
                                            <br>&nbsp;&nbsp;Admin: Rp {{ number_format($split->admin_amount, 0, ',', '.') }}
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-red-600">✗ Tidak ada split</span>
                                    <span class="text-xs text-red-500">(ERROR: Pesanan completed harus punya earning
                                        split)</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 italic">Tidak ada pesanan selesai</p>
                @endif
            </div>

            <!-- Processing Orders -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-blue-600">Pesanan Diproses (Should NOT Have Earnings)</h2>

                @if ($processingOrders->count() > 0)
                    @foreach ($processingOrders as $order)
                        <div class="border-b pb-3 mb-3 last:border-b-0">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <strong>Order #{{ $order->order_number }}</strong><br>
                                    <small class="text-gray-500">{{ $order->customer_name }}</small>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm">Status: <span
                                            class="text-blue-600 font-semibold">{{ $order->status }}</span></div>
                                    <div class="text-sm">Payment: <span
                                            class="text-green-600 font-semibold">{{ $order->payment_status }}</span></div>
                                </div>
                            </div>

                            <div class="text-sm">
                                <strong>Konfirmasi:</strong><br>
                                <div class="ml-4 text-xs">
                                    Customer: @if ($order->customer_confirmed)
                                    <span class="text-green-600">✓</span>@else<span class="text-red-600">✗</span>
                                    @endif
                                    <br>
                                    Tukang: @if ($order->tukang_confirmed)
                                    <span class="text-green-600">✓</span>@else<span class="text-red-600">✗</span>
                                    @endif
                                </div>
                            </div>

                            <div class="text-sm mt-1">
                                <strong>Earning Splits:</strong>
                                @if ($order->earningSplit && $order->earningSplit->count() > 0)
                                    <span class="text-red-600">✗ {{ $order->earningSplit->count() }} split(s)</span>
                                    <span class="text-xs text-red-500">(ERROR: Pesanan processing tidak boleh punya earning
                                        split)</span>
                                @else
                                    <span class="text-green-600">✓ Tidak ada split</span>
                                    <span class="text-xs text-green-500">(Benar: menunggu konfirmasi selesai)</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 italic">Tidak ada pesanan dalam proses</p>
                @endif
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('test.confirmation') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2">
                Test Confirmation System
            </a>
            <a href="{{ route('admin.earning-splits.index') }}"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                View Earning Splits (Admin)
            </a>
        </div>
    </div>
@endsection
