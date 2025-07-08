@extends('layouts.main')

@section('content')
    <div class="py-32 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold font-poppins text-gray-900">Pesanan Saya</h1>
                <p class="mt-2 text-gray-600 font-roboto">Kelola dan pantau semua pesanan layanan anda</p>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if ($orders->count() > 0)
                    <!-- Order List for Desktop -->
                    <div class="hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium font-poppins text-gray-500 uppercase tracking-wider">
                                        No. Pesanan
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium font-poppins text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium font-poppins text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium font-poppins text-gray-500 uppercase tracking-wider">
                                        Status Pesanan
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium font-poppins text-gray-500 uppercase tracking-wider">
                                        Status Pembayaran
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium font-poppins text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium font-roboto text-gray-900">
                                            {{ $order->order_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-roboto text-gray-500">
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-roboto text-gray-900">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold font-roboto rounded-full 
                                        @if ($order->status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800 
                                        @elseif($order->status == 'completed') bg-green-100 text-green-800 
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800 @endif">
                                                @if ($order->status == 'pending')
                                                    Menunggu
                                                @elseif($order->status == 'processing')
                                                    Diproses
                                                @elseif($order->status == 'completed')
                                                    Selesai
                                                @elseif($order->status == 'cancelled')
                                                    Dibatalkan
                                                @else
                                                    {{ $order->status }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold font-roboto rounded-full 
                                        @if ($order->payment_status == 'unpaid') bg-yellow-100 text-yellow-800 
                                        @elseif($order->payment_status == 'verifying') bg-blue-100 text-blue-800 
                                        @elseif($order->payment_status == 'paid') bg-green-100 text-green-800 
                                        @else bg-gray-100 text-gray-800 @endif">
                                                @if ($order->payment_status == 'unpaid')
                                                    Belum Bayar
                                                @elseif($order->payment_status == 'verifying')
                                                    Verifikasi
                                                @elseif($order->payment_status == 'paid')
                                                    Lunas
                                                @else
                                                    {{ ucfirst($order->payment_status) }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="{{ route('customer.orders.show', $order) }}"
                                                class="text-indigo-600 hover:text-indigo-900 font-poppins">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Order List for Mobile -->
                    <div class="md:hidden">
                        <ul class="divide-y divide-gray-200">
                            @foreach ($orders as $order)
                                <li class="p-4">
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <h3 class="text-sm font-semibold font-poppins text-gray-900">
                                                {{ $order->order_number }}</h3>
                                            <span
                                                class="text-xs font-roboto text-gray-500">{{ $order->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <p class="text-base font-semibold font-roboto text-gray-900">Rp
                                            {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                        <div class="flex justify-between items-center">
                                            <div class="flex space-x-2">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold font-roboto rounded-full 
                                                @if ($order->status == 'pending') bg-yellow-100 text-yellow-800 
                                                @elseif($order->status == 'processing') bg-blue-100 text-blue-800 
                                                @elseif($order->status == 'completed') bg-green-100 text-green-800 
                                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800 @endif">
                                                    @if ($order->status == 'pending')
                                                        Menunggu
                                                    @elseif($order->status == 'processing')
                                                        Diproses
                                                    @elseif($order->status == 'completed')
                                                        Selesai
                                                    @elseif($order->status == 'cancelled')
                                                        Dibatalkan
                                                    @else
                                                        {{ $order->status }}
                                                    @endif
                                                </span>
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold font-roboto rounded-full 
                                                @if ($order->payment_status == 'unpaid') bg-yellow-100 text-yellow-800 
                                                @elseif($order->payment_status == 'verifying') bg-blue-100 text-blue-800 
                                                @elseif($order->payment_status == 'paid') bg-green-100 text-green-800 
                                                @else bg-gray-100 text-gray-800 @endif">
                                                    @if ($order->payment_status == 'unpaid')
                                                        Belum Bayar
                                                    @elseif($order->payment_status == 'verifying')
                                                        Verifikasi
                                                    @elseif($order->payment_status == 'paid')
                                                        Lunas
                                                    @else
                                                        {{ ucfirst($order->payment_status) }}
                                                    @endif
                                                </span>
                                            </div>
                                            <a href="{{ route('customer.orders.show', $order) }}"
                                                class="text-indigo-600 hover:text-indigo-900 text-sm font-poppins">Lihat
                                                Detail</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="py-10 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-base font-medium font-poppins text-gray-900">Tidak ada pesanan</h3>
                        <p class="mt-1 text-sm text-gray-500 font-roboto">Anda belum membuat pesanan layanan.</p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542] font-poppins">
                                Pesan Layanan Sekarang
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
