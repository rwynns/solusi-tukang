@extends('layouts.main')

@section('title', 'Review Pesanan')

@section('content')
    <div class="bg-gray-50 py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="border-b border-gray-200 pb-8 mb-8">
                    <!-- Progress Steps Container -->
                    <div class="relative">
                        <!-- Background Track -->
                        <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200"></div>

                        <!-- Progress Bar - Width berubah berdasarkan langkah -->
                        <div class="absolute top-5 left-0 h-1 bg-[#332E60] transition-all duration-500 ease-in-out"
                            style="width: {{ (($currentStep - 1) / 3) * 100 }}%"></div>

                        <!-- Step Indicators -->
                        <div class="relative flex justify-between">
                            <!-- Step 1: Review Keranjang -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full
                     {{ $currentStep >= 1 ? 'bg-[#332E60] text-white' : 'bg-white border-2 border-gray-300 text-gray-500' }}">
                                    @if ($currentStep > 1)
                                        <!-- Checkmark Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <span>1</span>
                                    @endif
                                </div>
                                <span
                                    class="mt-2 text-xs {{ $currentStep == 1 ? 'font-medium text-gray-900' : 'text-gray-500' }}">Review
                                    Keranjang</span>
                            </div>

                            <!-- Step 2: Pilih Teknisi -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full
                     {{ $currentStep >= 2 ? 'bg-[#332E60] text-white' : 'bg-white border-2 border-gray-300 text-gray-500' }}">
                                    @if ($currentStep > 2)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <span>2</span>
                                    @endif
                                </div>
                                <span
                                    class="mt-2 text-xs {{ $currentStep == 2 ? 'font-medium text-gray-900' : 'text-gray-500' }}">Pilih
                                    Teknisi</span>
                            </div>

                            <!-- Step 3: Informasi Pengiriman -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full
                     {{ $currentStep >= 3 ? 'bg-[#332E60] text-white' : 'bg-white border-2 border-gray-300 text-gray-500' }}">
                                    @if ($currentStep > 3)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <span>3</span>
                                    @endif
                                </div>
                                <span
                                    class="mt-2 text-xs {{ $currentStep == 3 ? 'font-medium text-gray-900' : 'text-gray-500' }}">Informasi
                                    Pengiriman</span>
                            </div>

                            <!-- Step 4: Pembayaran -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full
                     {{ $currentStep >= 4 ? 'bg-[#332E60] text-white' : 'bg-white border-2 border-gray-300 text-gray-500' }}">
                                    @if ($currentStep > 4)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <span>4</span>
                                    @endif
                                </div>
                                <span
                                    class="mt-2 text-xs {{ $currentStep == 4 ? 'font-medium text-gray-900' : 'text-gray-500' }}">Pembayaran</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-2xl font-bold text-gray-900 font-poppins mb-6">Review Pesanan Anda</h2>

                        @if (count($cart) > 0)
                            <div class="border rounded-lg overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Layanan</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Harga</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Jumlah</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @php
                                            $total = 0;
                                        @endphp

                                        @foreach ($cart as $item)
                                            @php
                                                $subtotal = $item['price'] * $item['quantity'];
                                                $total += $subtotal;
                                            @endphp
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-md overflow-hidden">
                                                            <img class="h-10 w-10 object-cover" src="{{ $item['image'] }}"
                                                                alt="{{ $item['name'] }}"
                                                                onerror="this.onerror=null; this.src='/images/login-bg.png';">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $item['name'] }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                        @if (isset($item['satuan']) && $item['satuan'])
                                                            <span
                                                                class="text-xs text-gray-500">/{{ $item['satuan'] }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $item['quantity'] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="3"
                                                class="px-6 py-4 text-right text-sm font-medium text-gray-900">Total</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                                Rp {{ number_format($total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="mt-8 flex justify-between">
                                <a href="{{ route('cart.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Kembali ke Keranjang
                                </a>

                                <a href="{{ route('checkout.technicians') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#28244D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                    Lanjutkan ke Pilih Teknisi
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900">Keranjang Kosong</h3>
                                <p class="mt-1 text-sm text-gray-500">Keranjang belanja Anda kosong. Silakan tambahkan
                                    layanan terlebih dahulu.</p>
                                <div class="mt-6">
                                    <a href="{{ route('home') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#28244D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                        Lihat Layanan
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .step {
            @apply flex flex-col items-center;
        }

        .step-number {
            @apply flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium border border-gray-300 bg-white text-gray-500;
        }

        .step-text {
            @apply mt-2 text-xs text-gray-500;
        }

        .step-active .step-number {
            @apply bg-[#332E60] text-white border-[#332E60];
        }

        .step-active .step-text {
            @apply text-gray-900 font-medium;
        }
    </style>
@endsection
