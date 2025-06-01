@extends('layouts.main')

@section('title', 'Pilih Metode Pembayaran')

@section('content')
    <div class="bg-gray-50 py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Progress Steps Container (tetap sama) -->
                <div class="border-b border-gray-200 pb-8 mb-8">
                    <div class="relative">
                        <!-- Background Track -->
                        <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200"></div>

                        <!-- Progress Bar - Width berubah berdasarkan langkah -->
                        <div class="absolute top-5 left-0 h-1 bg-[#332E60] transition-all duration-500 ease-in-out"
                            style="width: 100%"></div>

                        <!-- Step Indicators -->
                        <div class="relative flex justify-between">
                            <!-- Step 1: Review Keranjang -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full bg-[#332E60] text-white">
                                    <!-- Checkmark Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs text-gray-500">Review Keranjang</span>
                            </div>

                            <!-- Step 2: Pilih Teknisi -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full bg-[#332E60] text-white">
                                    <!-- Checkmark Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs text-gray-500">Pilih Teknisi</span>
                            </div>

                            <!-- Step 3: Informasi Pengiriman -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full bg-[#332E60] text-white">
                                    <!-- Checkmark Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs text-gray-500">Informasi Pengiriman</span>
                            </div>

                            <!-- Step 4: Pembayaran -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full bg-[#332E60] text-white">
                                    <span>4</span>
                                </div>
                                <span class="mt-2 text-xs font-medium text-gray-900">Pembayaran</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-2xl font-bold text-gray-900 font-poppins mb-6">Pilih Metode Pembayaran</h2>

                        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="space-y-6">
                                <!-- Ringkasan Pesanan (tetap sama) -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">Ringkasan Pesanan</h3>

                                    @php
                                        $cart = json_decode(request()->cookie('cart'), true) ?? [];
                                        $total = collect($cart)->sum(function ($item) {
                                            return $item['price'] * $item['quantity'];
                                        });
                                    @endphp

                                    <div class="mt-2 flex justify-between text-sm text-gray-500">
                                        <span>Total Layanan ({{ count($cart) }} item)</span>
                                        <span class="font-medium text-gray-900">Rp
                                            {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <!-- Opsi Pembayaran -->
                                <div>
                                    <fieldset>
                                        <legend class="text-base font-medium text-gray-900">Metode Pembayaran</legend>
                                        <div class="mt-4 space-y-4">
                                            @foreach ($paymentOptions as $option)
                                                <div class="relative flex items-start py-4 border-b border-gray-200">
                                                    <div class="min-w-0 flex-1 text-sm">
                                                        <label for="payment-{{ $option->id }}"
                                                            class="font-medium text-gray-700 cursor-pointer">
                                                            <div class="flex items-center">
                                                                @if ($option->logo)
                                                                    <img src="{{ asset('storage/' . $option->logo) }}"
                                                                        alt="{{ $option->name }}" class="h-8 w-auto mr-3">
                                                                @endif
                                                                {{ $option->name }}
                                                            </div>
                                                            <p class="text-gray-500 mt-1">{{ $option->description }}</p>
                                                        </label>
                                                    </div>
                                                    <div class="ml-3 flex items-center h-5">
                                                        <input id="payment-{{ $option->id }}" name="payment_option_id"
                                                            value="{{ $option->id }}" type="radio" required
                                                            class="focus:ring-[#332E60] h-4 w-4 text-[#332E60] border-gray-300 payment-option-radio"
                                                            {{ old('payment_option_id') == $option->id ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            @endforeach

                                            @error('payment_option_id')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </fieldset>
                                </div>

                                <!-- TAMBAHAN: Detail Metode Pembayaran -->
                                <div id="paymentDetailsContainer" class="mt-6 border border-gray-200 rounded-lg p-4 hidden">
                                    <h3 class="text-base font-medium text-gray-900 mb-3">Scan QR Code untuk Pembayaran</h3>

                                    @foreach ($paymentOptions as $option)
                                        <div id="payment-details-{{ $option->id }}"
                                            class="payment-detail-container hidden">
                                            <div class="text-center">
                                                <!-- QR Code -->
                                                <div
                                                    class="inline-block bg-white p-2 border border-gray-200 rounded-md mb-3">
                                                    @if ($option->qr_code)
                                                        <img src="{{ asset('storage/' . $option->qr_code) }}"
                                                            alt="{{ $option->name }} QR Code"
                                                            class="h-48 w-48 object-contain">
                                                    @else
                                                        <!-- Fallback jika QR code tidak tersedia -->
                                                        <div
                                                            class="h-48 w-48 flex items-center justify-center bg-gray-100 text-gray-400">
                                                            <svg class="h-12 w-12" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Informasi Rekening -->
                                                <div class="bg-gray-50 p-4 rounded-lg mt-4 text-left">
                                                    <div class="flex items-center">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-medium text-gray-900">
                                                                {{ $option->name }}</p>
                                                            <p class="text-sm text-gray-700">Nomor:
                                                                {{ $option->account_number ?? '1234567890' }}</p>
                                                            <p class="text-sm text-gray-700">
                                                                {{ 'A.N. ' . ($option->account_name ?? 'Nama Pemilik Rekening') }}
                                                            </p>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    Pembayaran harus dilakukan dalam waktu 24 jam setelah pesanan dibuat
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Tambahan -->
                                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800">
                                                Petunjuk Pembayaran
                                            </h3>
                                            <div class="mt-2 text-sm text-blue-700">
                                                <ul class="list-disc pl-5 space-y-1">
                                                    <li>Mohon lakukan pembayaran sesuai dengan total yang tertera</li>
                                                    <li>Sertakan nomor pesanan
                                                        <strong>{{ session('temp_order_number', 'xxxxx') }}</strong> pada
                                                        keterangan transfer
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tambahan: Upload Bukti Pembayaran -->
                                <div class="mt-6 border border-gray-200 rounded-lg p-4">
                                    <h3 class="text-base font-medium text-gray-900 mb-3">Upload Bukti Pembayaran</h3>

                                    <div class="mb-4">
                                        <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-1">
                                            Bukti Transfer <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1 flex items-center">
                                            <input type="file" id="payment_proof" name="payment_proof"
                                                accept="image/*"
                                                class="block w-full text-sm text-gray-500
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-md file:border-0
                                                file:text-sm file:font-medium
                                                file:bg-[#332E60] file:text-white
                                                hover:file:bg-[#28244D]"
                                                required>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Upload bukti transfer dalam format JPG, PNG
                                            (maks 2MB)</p>
                                    </div>

                                    <div>
                                        <label for="payment_notes" class="block text-sm font-medium text-gray-700 mb-1">
                                            Catatan (Opsional)
                                        </label>
                                        <textarea id="payment_notes" name="payment_notes" rows="2"
                                            class="shadow-sm focus:ring-[#332E60] focus:border-[#332E60] block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="Misal: Transfer dari rekening atas nama..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-between">
                                <a href="{{ route('checkout.delivery') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Kembali
                                </a>

                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#28244D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                    Selesaikan Pesanan
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('.payment-option-radio');
            const paymentDetailsContainer = document.getElementById('paymentDetailsContainer');
            const paymentDetailContainers = document.querySelectorAll('.payment-detail-container');

            // Show payment details based on selected option
            function showPaymentDetails(paymentOptionId) {
                // Hide all payment details first
                paymentDetailContainers.forEach(detail => {
                    detail.classList.add('hidden');
                });

                // Show the container
                paymentDetailsContainer.classList.remove('hidden');

                // Show the specific payment details
                const detailElement = document.getElementById(`payment-details-${paymentOptionId}`);
                if (detailElement) {
                    detailElement.classList.remove('hidden');
                }
            }

            // Event listeners for radio buttons
            paymentOptions.forEach(option => {
                // If option is already checked on page load, show its details
                if (option.checked) {
                    showPaymentDetails(option.value);
                }

                // When option is clicked
                option.addEventListener('change', function() {
                    showPaymentDetails(this.value);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(e) {
                console.log('Form is being submitted');
                // Optional: Add a loading state
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = 'Memproses...';
            });
        });
    </script>
@endsection
