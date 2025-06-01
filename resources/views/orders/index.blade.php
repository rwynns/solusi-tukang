@extends('layouts.main')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="bg-gray-50 py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 font-poppins mb-8">Pesanan Saya</h1>

                @if ($orders->isEmpty())
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-8 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada pesanan</h3>
                            <p class="mt-2 text-sm text-gray-500">Anda belum melakukan pesanan apapun.</p>
                            <div class="mt-6">
                                <a href="{{ route('home') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#332E60] hover:bg-[#28244D]">
                                    Jelajahi Layanan
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No. Pesanan
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pembayaran
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $order->order_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $order->status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : ($order->status === 'processing'
                                                    ? 'bg-blue-100 text-blue-800'
                                                    : ($order->status === 'completed'
                                                        ? 'bg-green-100 text-green-800'
                                                        : 'bg-red-100 text-red-800')) }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $order->payment_status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : ($order->payment_status === 'paid'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('orders.show', $order->id) }}"
                                                    class="text-[#332E60] hover:text-[#28244D]">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
