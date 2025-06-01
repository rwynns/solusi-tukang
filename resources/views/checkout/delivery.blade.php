@extends('layouts.main')

@section('title', 'Informasi Pengiriman')

@section('content')
    <div class="bg-gray-50 py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Progress Steps Container -->
                <div class="border-b border-gray-200 pb-8 mb-8">
                    <div class="relative">
                        <!-- Background Track -->
                        <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200"></div>

                        <!-- Progress Bar - Width berubah berdasarkan langkah -->
                        <div class="absolute top-5 left-0 h-1 bg-[#332E60] transition-all duration-500 ease-in-out"
                            style="width: 66.67%"></div>

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
                                    <span>3</span>
                                </div>
                                <span class="mt-2 text-xs font-medium text-gray-900">Informasi Pengiriman</span>
                            </div>

                            <!-- Step 4: Pembayaran -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full bg-white border-2 border-gray-300 text-gray-500">
                                    <span>4</span>
                                </div>
                                <span class="mt-2 text-xs text-gray-500">Pembayaran</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-2xl font-bold text-gray-900 font-poppins mb-6">Informasi Lokasi Layanan</h2>

                        <form action="{{ route('checkout.save-delivery') }}" method="POST">
                            @csrf

                            <div class="space-y-6">
                                <!-- Nama Lengkap -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span
                                            class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $user->name ?? '') }}"
                                            class="cshadow-sm py-2 px-3 focus:ring-[#332E60] focus:border-[#332E60] block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-500 @enderror"
                                            required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nomor Telepon -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon
                                        <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="tel" id="phone" name="phone"
                                            value="{{ old('phone', $user->phone_number ?? '') }}"
                                            class="shadow-sm py-2 px-3 focus:ring-[#332E60] focus:border-[#332E60] block w-full sm:text-sm border-gray-300 rounded-md @error('phone') border-red-500 @enderror"
                                            required>
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Pastikan nomor telepon aktif dan dapat dihubungi
                                        oleh teknisi</p>
                                </div>

                                <!-- Alamat Lengkap -->
                                <div>
                                    <label for="customer_address" class="block text-sm font-medium text-gray-700">Alamat
                                        Pengerjaan <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <textarea id="customer_address" name="customer_address" rows="3"
                                            class="shadow-sm py-2 px-3 focus:ring-[#332E60] focus:border-[#332E60] block w-full sm:text-sm border-gray-300 rounded-md @error('customer_address') border-red-500 @enderror"
                                            required>{{ old('customer_address', session('checkout.delivery.customer_address') ?? ($user->address ?? '')) }}</textarea>
                                        @error('customer_address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Berikan alamat lengkap lokasi pengerjaan termasuk
                                        patokan agar teknisi mudah menemukan lokasi</p>
                                </div>

                                <!-- Catatan Tambahan -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan
                                        Tambahan</label>
                                    <div class="mt-1">
                                        <textarea id="notes" name="notes" rows="3"
                                            class="shadow-sm py-2 px-3 focus:ring-[#332E60] focus:border-[#332E60] block w-full sm:text-sm border-gray-300 rounded-md">{{ old('notes', session('checkout.delivery.notes') ?? '') }}</textarea>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Informasi tambahan yang perlu diketahui teknisi
                                        (opsional)</p>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-between">
                                <a href="{{ route('checkout.technicians') }}"
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
                                    Lanjutkan ke Pembayaran
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
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
