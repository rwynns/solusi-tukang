@extends('layouts.dashboard')

@section('title', 'Detail Pemesanan')

@section('content')
    <!-- Page header -->
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold font-poppins text-gray-900">Detail Pemesanan</h1>
                    <p class="mt-1 text-sm text-gray-500">Order #{{ $order->order_number }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.orders.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium font-poppins rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <!-- BARIS 1: Status Pemesanan dan Detail Jasa -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Status Pemesanan -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 flex justify-between">
                        <div>
                            <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Status Pemesanan</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Tanggal Pemesanan:
                                {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <!-- Tombol Ubah Status -->
                            <button type="button"
                                class="text-blue-600 hover:text-blue-900 status-update-btn flex items-center"
                                data-id="{{ $order->id }}" data-status="{{ $order->status }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"
                                        clip-rule="evenodd" />
                                </svg>
                                Ubah Status
                            </button>

                            <!-- Tombol Ubah Status Pembayaran -->
                            <button type="button"
                                class="text-green-600 hover:text-green-900 payment-update-btn flex items-center"
                                data-id="{{ $order->id }}" data-payment-status="{{ $order->payment_status }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Ubah Pembayaran
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status Pemesanan</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $order->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($order->status === 'processing'
                                                ? 'bg-blue-100 text-blue-800'
                                                : ($order->status === 'completed'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $order->payment_status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($order->payment_status === 'verifying'
                                                ? 'bg-blue-100 text-blue-800'
                                                : ($order->payment_status === 'paid'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800')) }}">
                                        {{ $order->payment_status === 'verifying' ? 'Menunggu Verifikasi' : ucfirst($order->payment_status) }}
                                    </span>
                                </dd>
                            </div>
                        </div>

                        <div class="px-4 py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 mb-1">Alamat Pengerjaan</dt>
                            <dd class="mt-1 text-sm text-gray-900 bg-gray-50 rounded p-2">
                                {{ $order->customer_address }}
                            </dd>

                            @if ($order->notes)
                                <dt class="text-sm font-medium text-gray-500 mt-3 mb-1">Catatan Pesanan</dt>
                                <dd class="text-sm text-gray-900 bg-gray-50 rounded p-2">
                                    {{ $order->notes }}
                                </dd>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detail Jasa -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Detail Jasa</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Jasa yang dipesan oleh customer</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jasa
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if ($order->orderItems && count($order->orderItems) > 0)
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $item->name }}
                                                    @if ($item->tukangProfile)
                                                        <div class="text-xs text-blue-600 mt-1">
                                                            Teknisi: {{ $item->tukangProfile->user->name }}
                                                        </div>
                                                    @else
                                                        <div class="text-xs text-yellow-600 mt-1">
                                                            Teknisi belum ditentukan
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">
                                                Tidak ada item untuk pesanan ini
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                            Total</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BARIS 2: Info Customer, Pembayaran, dan Bukti Pembayaran -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Informasi Customer -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Informasi Customer</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                        <dl class="sm:divide-y sm:divide-gray-200">
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $order->customer_name }}</dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $order->customer_phone }}</dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->user->email }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Informasi Pembayaran -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Informasi Pembayaran</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                        <dl class="sm:divide-y sm:divide-gray-200">
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $order->paymentOption ? $order->paymentOption->name : 'N/A' }}
                                </dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Total Bayar</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-900 sm:mt-0 sm:col-span-2">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                                <dd class="mt-1 sm:mt-0 sm:col-span-2">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $order->payment_status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($order->payment_status === 'verifying'
                                                ? 'bg-blue-100 text-blue-800'
                                                : ($order->payment_status === 'paid'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800')) }}">
                                        {{ $order->payment_status === 'verifying' ? 'Menunggu Verifikasi' : ucfirst($order->payment_status) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Bukti Pembayaran -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Bukti Pembayaran</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5">
                        @if ($order->payment && $order->payment->payment_proof)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $order->payment->payment_proof) }}"
                                    alt="Bukti Pembayaran" class="max-w-full h-auto rounded-lg border border-gray-200">
                                <p class="mt-2 text-xs text-gray-500">Diunggah pada:
                                    {{ $order->payment->updated_at->format('d M Y, H:i') }}</p>
                            </div>

                            @if ($order->payment->customer_notes)
                                <div class="mt-4 mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-1">Catatan dari Customer:</h4>
                                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-md">
                                        {{ $order->payment->customer_notes }}</p>
                                </div>
                            @endif

                            @if ($order->payment_status === 'verifying')
                                <div class="mt-4">
                                    <form action="{{ route('admin.orders.update-payment', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="payment_status" value="paid">
                                        <button type="submit"
                                            class="inline-flex justify-center w-full px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Verifikasi Pembayaran
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if ($order->payment_status === 'paid' && $order->payment->verified_at)
                                <div class="mt-4 bg-green-50 border-l-4 border-green-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-700">
                                                Pembayaran telah diverifikasi pada
                                                {{ $order->payment->verified_at->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="flex flex-col items-center justify-center py-6">
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Belum ada bukti pembayaran yang diunggah</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Status Update Modal -->
    <div id="statusUpdateModal" class="fixed inset-0 z-50 flex items-center justify-center hidden"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="relative bg-white rounded-lg shadow-2xl max-w-lg w-full transform transition-all">
            <form id="statusUpdateForm" method="POST">
                @csrf
                @method('PATCH')
                <!-- Tombol X di pojok kanan atas -->
                <button type="button" id="closeStatusModal"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="sr-only">Close</span>
                </button>

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Perbarui Status Pesanan
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Pilih status baru untuk pesanan ini:
                                </p>
                                <select name="status" id="statusSelect"
                                    class="mt-3 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#F4C542] focus:border-[#F4C542] sm:text-sm rounded-md">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#332E60] text-base font-medium text-white hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542] sm:ml-3 sm:w-auto sm:text-sm">
                        Update
                    </button>
                    <button type="button"
                        class="close-modal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Payment Status Update Modal -->
    <div id="paymentUpdateModal" class="fixed inset-0 z-50 flex items-center justify-center hidden"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="relative bg-white rounded-lg shadow-2xl max-w-lg w-full transform transition-all">
            <form id="paymentUpdateForm" method="POST">
                @csrf
                @method('PATCH')
                <!-- Tombol X di pojok kanan atas -->
                <button type="button" id="closePaymentModal"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="sr-only">Close</span>
                </button>

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Perbarui Status Pembayaran
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Pilih status pembayaran baru untuk pesanan ini:
                                </p>
                                <select name="payment_status" id="paymentStatusSelect"
                                    class="mt-3 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#F4C542] focus:border-[#F4C542] sm:text-sm rounded-md">
                                    <option value="pending">Pending</option>
                                    <option value="verifying">Menunggu Verifikasi</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update
                    </button>
                    <button type="button"
                        class="close-payment-modal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status Update Modal
            const statusUpdateButtons = document.querySelectorAll('.status-update-btn');
            const statusUpdateModal = document.getElementById('statusUpdateModal');
            const statusUpdateForm = document.getElementById('statusUpdateForm');
            const statusSelect = document.getElementById('statusSelect');
            const closeStatusModal = document.getElementById('closeStatusModal');
            const closeModalButtons = document.querySelectorAll('.close-modal');

            // Tombol update status
            if (statusUpdateButtons && statusUpdateModal && statusUpdateForm && statusSelect) {
                statusUpdateButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const orderId = this.getAttribute('data-id');
                        const currentStatus = this.getAttribute('data-status');

                        // Set current status in select
                        statusSelect.value = currentStatus;

                        // Set form action
                        statusUpdateForm.action = `/admin/orders/${orderId}/update-status`;

                        // Show modal
                        statusUpdateModal.classList.remove('hidden');
                    });
                });
            }

            // Payment Status Update Modal
            const paymentUpdateButtons = document.querySelectorAll('.payment-update-btn');
            const paymentUpdateModal = document.getElementById('paymentUpdateModal');
            const paymentUpdateForm = document.getElementById('paymentUpdateForm');
            const paymentStatusSelect = document.getElementById('paymentStatusSelect');
            const closePaymentModal = document.getElementById('closePaymentModal');
            const closePaymentModalButtons = document.querySelectorAll('.close-payment-modal');

            // Tombol update payment status
            if (paymentUpdateButtons && paymentUpdateModal && paymentUpdateForm && paymentStatusSelect) {
                paymentUpdateButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const orderId = this.getAttribute('data-id');
                        const currentPaymentStatus = this.getAttribute('data-payment-status');

                        // Set current status in select
                        paymentStatusSelect.value = currentPaymentStatus;

                        // Set form action
                        paymentUpdateForm.action = `/admin/orders/${orderId}/update-payment`;

                        // Show modal
                        paymentUpdateModal.classList.remove('hidden');
                    });
                });
            }

            // Handle close events

            // Close dengan tombol X dan tombol Batal
            if (closeStatusModal) {
                closeStatusModal.addEventListener('click', function() {
                    statusUpdateModal.classList.add('hidden');
                });
            }

            if (closePaymentModal) {
                closePaymentModal.addEventListener('click', function(e) {
                    e.preventDefault();
                    paymentUpdateModal.classList.add('hidden');
                });
            }

            // Juga menggunakan class close-modal untuk menutup modal
            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    statusUpdateModal.classList.add('hidden');
                });
            });

            // Close dengan class close-payment-modal
            closePaymentModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    paymentUpdateModal.classList.add('hidden');
                });
            });

            // Close dengan ESC key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    statusUpdateModal.classList.add('hidden');
                    paymentUpdateModal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
