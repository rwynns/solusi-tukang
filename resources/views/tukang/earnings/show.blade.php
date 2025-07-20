@extends('layouts.dashboard')

@section('title', 'Detail Pendapatan')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Page header -->
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Detail Pendapatan</h1>
                            <p class="text-sm text-gray-600 mt-1">Order #{{ $earning->order->order_number }}</p>
                        </div>
                        <a href="{{ route('tukang.earnings.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            ← Kembali ke Penghasilan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Order Info -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-medium text-gray-700">Informasi Order</h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Nomor Order</h4>
                                        <p class="mt-1 text-sm text-gray-900">#{{ $earning->order->order_number }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Status Order</h4>
                                        <p class="mt-1">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $earning->order->status === 'completed'
                                                    ? 'bg-green-100 text-green-800'
                                                    : ($earning->order->status === 'in_progress'
                                                        ? 'bg-blue-100 text-blue-800'
                                                        : ($earning->order->status === 'pending'
                                                            ? 'bg-yellow-100 text-yellow-800'
                                                            : 'bg-red-100 text-red-800')) }}">
                                                {{ ucfirst($earning->order->status) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Nama Customer</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $earning->order->customer_name }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Telepon Customer</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $earning->order->customer_phone }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Alamat</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $earning->order->customer_address }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Tanggal Order</h4>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $earning->order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                @if ($earning->order->notes)
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-500">Catatan Customer</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $earning->order->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-medium text-gray-700">Detail Layanan</h3>
                            </div>
                            <div class="p-6">
                                @if ($earning->order->orderItems && $earning->order->orderItems->count() > 0)
                                    <div class="space-y-4">
                                        @foreach ($earning->order->orderItems as $item)
                                            <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <h4 class="text-sm font-medium text-gray-900">
                                                            {{ $item->subJasa->nama ?? ($item->name ?? 'Layanan tidak ditemukan') }}
                                                        </h4>
                                                        @if ($item->subJasa && $item->subJasa->jasa)
                                                            <p class="text-sm text-gray-500">
                                                                {{ $item->subJasa->jasa->nama }}</p>
                                                        @endif
                                                        <div class="mt-2 text-sm text-gray-600">
                                                            <p>Quantity: {{ $item->quantity }}</p>
                                                            <p>Harga satuan:
                                                                Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4 text-right">
                                                        <p class="text-sm font-medium text-gray-900">
                                                            Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">Tidak ada detail layanan</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Earnings Summary -->
                    <div class="space-y-6">
                        <!-- Payment Status -->
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-medium text-gray-700">Status Pembayaran</h3>
                            </div>
                            <div class="p-6">
                                <div class="text-center">
                                    <span
                                        class="px-3 py-1 text-sm font-semibold rounded-full
                                        {{ $earning->status === 'distributed'
                                            ? 'bg-green-100 text-green-800'
                                            : ($earning->status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-red-100 text-red-800') }}">
                                        @if ($earning->status === 'distributed')
                                            Sudah Dibayar
                                        @elseif($earning->status === 'pending')
                                            Menunggu Pembayaran
                                        @else
                                            Ditahan
                                        @endif
                                    </span>

                                    @if ($earning->distributed_at)
                                        <p class="mt-2 text-sm text-gray-600">
                                            Dibayar pada: {{ $earning->distributed_at->format('d M Y, H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Earnings Breakdown -->
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-medium text-gray-700">Rincian Pendapatan</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Total Order</span>
                                        <span class="text-sm font-medium text-gray-900">
                                            Rp{{ number_format($earning->total_amount, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="border-t border-gray-200 pt-4">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Platform Fee (10%)</span>
                                            <span class="text-sm font-medium text-red-600">
                                                -Rp{{ number_format($earning->admin_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between mt-2">
                                            <span class="text-sm text-gray-600">Pendapatan Anda (90%)</span>
                                            <span class="text-sm font-medium text-green-600">
                                                Rp{{ number_format($earning->tukang_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="border-t border-gray-200 pt-4">
                                        <div class="flex justify-between">
                                            <span class="text-base font-medium text-gray-900">Total Pendapatan</span>
                                            <span class="text-base font-bold text-[#332E60]">
                                                Rp{{ number_format($earning->tukang_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mt-0.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                                    <div class="mt-1 text-sm text-blue-700">
                                        <p>• Pembayaran akan diproses setelah order selesai</p>
                                        <p>• Status "Distributed" berarti dapat ditarik</p>
                                        <p>• Hubungi admin jika ada pertanyaan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
