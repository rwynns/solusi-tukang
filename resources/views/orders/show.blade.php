@extends('layouts.main')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="bg-gray-50 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 font-poppins">Detail Pesanan</h1>
                        <p class="text-sm text-gray-500">Nomor Pesanan: {{ $order->order_number }}</p>
                    </div>

                    <a href="{{ route('orders.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- ROW 1: Status Pemesanan dan Detail Jasa -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Status Pemesanan -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden h-full">
                        <div class="px-4 py-4 sm:px-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Status Pemesanan</h2>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-sm text-gray-500">Tanggal Pesan:
                                    {{ $order->created_at->format('d M Y, H:i') }}</p>
                                @if ($order->completed_at)
                                    <p class="text-sm text-gray-500">Selesai:
                                        {{ $order->completed_at->format('d M Y, H:i') }}</p>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg text-center">
                                    <span class="block text-sm text-gray-500 mb-2">Status Pesanan</span>
                                    <span
                                        class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                        {{ $order->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($order->status === 'processing'
                                                ? 'bg-blue-100 text-blue-800'
                                                : ($order->status === 'completed'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg text-center">
                                    <span class="block text-sm text-gray-500 mb-2">Status Pembayaran</span>
                                    <span
                                        class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                        {{ $order->payment_status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($order->payment_status === 'verifying'
                                                ? 'bg-blue-100 text-blue-800'
                                                : ($order->payment_status === 'paid'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800')) }}">
                                        {{ $order->payment_status === 'verifying' ? 'Menunggu Verifikasi' : ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h3 class="text-sm font-medium text-gray-900 mb-2">Lokasi Pengerjaan:</h3>
                                <p class="text-sm text-gray-700 p-3 bg-gray-50 rounded-md">{{ $order->customer_address }}
                                </p>

                                @if ($order->notes)
                                    <div class="mt-3">
                                        <h3 class="text-sm font-medium text-gray-900 mb-1">Catatan:</h3>
                                        <p class="text-sm text-gray-500 p-3 bg-gray-50 rounded-md">{{ $order->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Detail Jasa -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden h-full">
                        <div class="px-4 py-4 sm:px-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Detail Jasa</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($order->items as $item)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="text-sm font-medium text-gray-900">{{ $item->name }}</h3>
                                                <p class="mt-1 text-sm text-gray-500">{{ $item->quantity }} x Rp
                                                    {{ number_format($item->price, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-900">Rp
                                                    {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        @if ($item->tukangProfile)
                                            <div class="mt-3 pt-3 border-t border-gray-200">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-8 w-8 rounded-full overflow-hidden bg-gray-200">
                                                        <img src="{{ $item->tukangProfile->profile_photo ? Storage::url($item->tukangProfile->profile_photo) : '/images/default-avatar.png' }}"
                                                            alt="{{ $item->tukangProfile->user->name }}"
                                                            class="h-full w-full object-cover">
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-xs font-medium text-gray-900">Teknisi:
                                                            {{ $item->tukangProfile->user->name }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $item->tukangProfile->phone_number }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-3 pt-3 border-t border-gray-200">
                                                <p class="text-xs text-yellow-600">Teknisi belum ditugaskan</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-base font-medium text-gray-900">Total</span>
                                    <span class="text-base font-medium text-gray-900">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 2: Informasi Customer, Pembayaran, dan Bukti Pembayaran -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Informasi Customer -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-4 py-4 sm:px-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Informasi Pelanggan</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Nama</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Telepon</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $order->customer_phone }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Email</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $order->user->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pembayaran -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-4 py-4 sm:px-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Informasi Pembayaran</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Metode Pembayaran</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">{{ $order->paymentOption->name }}</span>
                                </div>

                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Nomor Rekening</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">{{ $order->paymentOption->account_number }}</span>
                                </div>

                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Atas Nama</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">{{ $order->paymentOption->account_name }}</span>
                                </div>

                                <div class="pt-3 border-t border-gray-200">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-gray-900">Total</span>
                                        <span class="text-base font-medium text-gray-900">Rp
                                            {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-4 py-4 sm:px-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Bukti Pembayaran</h2>
                        </div>
                        <div class="p-6">
                            @if ($order->payment && $order->payment->payment_proof)
                                <div class="text-center mb-4">
                                    <span
                                        class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                        {{ $order->payment_status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($order->payment_status === 'verifying'
                                                ? 'bg-blue-100 text-blue-800'
                                                : ($order->payment_status === 'paid'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800')) }}">
                                        {{ $order->payment_status === 'verifying' ? 'Menunggu Verifikasi' : ucfirst($order->payment_status) }}
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $order->payment->payment_proof) }}"
                                        alt="Bukti Pembayaran" class="w-full h-auto rounded-md border border-gray-200">
                                    <p class="mt-2 text-xs text-gray-500 text-center">
                                        Diunggah pada: {{ $order->payment->updated_at->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                @if ($order->payment->customer_notes)
                                    <div class="mt-4">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Catatan Pembayaran:</p>
                                        <p class="text-sm text-gray-600 bg-gray-50 p-2 rounded-md">
                                            {{ $order->payment->customer_notes }}
                                        </p>
                                    </div>
                                @endif
                            @else
                                <div class="flex flex-col items-center justify-center py-6">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Belum ada bukti pembayaran</p>

                                    @if ($order->payment_status === 'pending')
                                        <a href="{{ route('orders.payment.show', $order) }}"
                                            class="mt-3 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                                            Unggah Bukti Pembayaran
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Support Information (Optional) -->
                @if ($order->status !== 'completed' && $order->status !== 'cancelled')
                    <div class="mt-6 bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4">
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">
                                            Butuh Bantuan?
                                        </h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>
                                                Jika Anda memiliki pertanyaan atau kendala terkait pesanan ini, silakan
                                                hubungi customer service kami di nomor <a href="tel:+628123456789"
                                                    class="font-medium underline">0812-3456-789</a> atau melalui email
                                                <a href="mailto:cs@solusitukang.com"
                                                    class="font-medium underline">cs@solusitukang.com</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
