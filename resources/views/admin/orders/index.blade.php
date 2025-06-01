@extends('layouts.dashboard')

@section('title', 'Kelola Pemesanan')

@section('content')
    <!-- Page header -->
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold font-poppins text-gray-900">Kelola Pemesanan</h1>
                <div class="flex space-x-3">
                    <a href="#" onclick="exportOrders(event)"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium font-poppins rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Export Data
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <!-- Filter & Search -->
        <div class="bg-white px-4 py-3 shadow rounded-lg mb-6">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="col-span-1 md:col-span-2">
                    <label for="search" class="sr-only">Cari</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="focus:ring-[#F4C542] focus:border-[#F4C542] block w-full h-10 pl-10 sm:text-sm border-gray-300 rounded-md font-roboto"
                            placeholder="Cari order number, nama, atau no. telepon...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="sr-only">Status Pesanan</label>
                    <select id="status" name="status"
                        class="block w-full h-10 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#F4C542] focus:border-[#F4C542] sm:text-sm rounded-md font-roboto">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                        </option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>

                <!-- Payment Status Filter -->
                <div>
                    <label for="payment_status" class="sr-only">Status Pembayaran</label>
                    <select id="payment_status" name="payment_status"
                        class="block w-full h-10 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#F4C542] focus:border-[#F4C542] sm:text-sm rounded-md font-roboto">
                        <option value="">Semua Status Pembayaran</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="verifying" {{ request('payment_status') == 'verifying' ? 'selected' : '' }}>Menunggu
                            Verifikasi</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>

                <!-- Filter Buttons -->
                <div class="col-span-1 md:col-span-4 flex space-x-2 justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium font-poppins rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd" />
                        </svg>
                        Filter
                    </button>

                    <a href="{{ route('admin.orders.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium font-poppins rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                clip-rule="evenodd" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            @if (isset($orders) && count($orders) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#292650]">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                No. Pesanan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Customer
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Pembayaran
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($orders as $index => $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-roboto">
                                    {{ $index + $orders->firstItem() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 font-roboto">{{ $order->order_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 font-roboto">{{ $order->customer_name }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $order->customer_phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-roboto text-gray-900">
                                        {{ $order->created_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium font-roboto">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <!-- Tombol Detail -->
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="text-[#332E60] hover:text-[#292650]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>

                                        <!-- Tombol Ubah Status -->
                                        <button type="button" class="text-blue-600 hover:text-blue-900 status-update-btn"
                                            data-id="{{ $order->id }}" data-status="{{ $order->status }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <!-- Tombol Ubah Status Pembayaran -->
                                        <button type="button"
                                            class="text-green-600 hover:text-green-900 payment-update-btn"
                                            data-id="{{ $order->id }}"
                                            data-payment-status="{{ $order->payment_status }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $orders->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data pesanan</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada pesanan yang sesuai dengan filter yang dipilih.</p>
                </div>
            @endif
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
                        statusUpdateForm.action = `/admin/orders/${orderId}/status`;

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

            // Tambahkan console.log untuk debugging
            console.log('Payment Elements:', {
                buttons: paymentUpdateButtons.length,
                modal: !!paymentUpdateModal,
                form: !!paymentUpdateForm,
                select: !!paymentStatusSelect,
                closeButton: !!closePaymentModal
            });

            // Tombol update payment status
            if (paymentUpdateButtons && paymentUpdateModal && paymentUpdateForm && paymentStatusSelect) {
                paymentUpdateButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const orderId = this.getAttribute('data-id');
                        const currentPaymentStatus = this.getAttribute('data-payment-status');

                        console.log('Payment Update:', {
                            orderId,
                            currentPaymentStatus
                        });

                        // Set current status in select
                        paymentStatusSelect.value = currentPaymentStatus;

                        // Set form action - PASTIKAN URL INI BENAR
                        paymentUpdateForm.action = `/admin/orders/${orderId}/payment-status`;

                        console.log('Form action set to:', paymentUpdateForm.action);

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
                    console.log('Close payment modal button clicked');
                    paymentUpdateModal.classList.add('hidden');
                });
            }

            // Juga menggunakan class close-modal untuk menutup modal
            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    statusUpdateModal.classList.add('hidden');
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

        // Export function
        function exportOrders(event) {
            event.preventDefault();

            // Get current filter parameters
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status') || '';
            const paymentStatus = urlParams.get('payment_status') || '';
            const search = urlParams.get('search') || '';

            // Redirect to export URL with same filters
            window.location.href = `/admin/orders/export?status=${status}&payment_status=${paymentStatus}&search=${search}`;
        }
    </script>
@endsection
