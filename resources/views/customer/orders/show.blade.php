@extends('layouts.main')

@section('content')
    <div class="py-32 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold font-poppins text-gray-900">Detail Pesanan</h1>
                    <p class="mt-1 text-gray-600 font-roboto">Nomor pesanan: {{ $order->order_number }}</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('customer.orders.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542] font-poppins">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali ke Daftar Pesanan
                    </a>
                </div>
            </div>

            <!-- Status dan Tindakan -->
            <div class="mb-6 bg-white rounded-lg shadow overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex flex-col space-y-3 sm:space-y-0 sm:flex-row sm:space-x-6">
                            <div>
                                <span class="text-sm font-roboto text-gray-500">Status Pesanan:</span>
                                <span
                                    class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold font-roboto rounded-full 
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
                            </div>
                            <div>
                                <span class="text-sm font-roboto text-gray-500">Status Pembayaran:</span>
                                <span
                                    class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold font-roboto rounded-full 
                                @if ($order->payment_status == 'pending') bg-yellow-100 text-yellow-800 
                                @elseif($order->payment_status == 'verifying') bg-blue-100 text-blue-800 
                                @elseif($order->payment_status == 'paid') bg-green-100 text-green-800 
                                @elseif($order->payment_status == 'cancelled') bg-red-100 text-red-800 @endif">
                                    @if ($order->payment_status == 'pending')
                                        Belum Bayar
                                    @elseif($order->payment_status == 'verifying')
                                        Verifikasi
                                    @elseif($order->payment_status == 'paid')
                                        Lunas
                                    @elseif($order->payment_status == 'cancelled')
                                        Dibatalkan
                                    @else
                                        {{ $order->payment_status }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if ($order->status == 'pending' || $order->status == 'unpaid')
                            <div class="mt-4 sm:mt-0">
                                <form action="{{ route('customer.orders.cancel', $order) }}" method="POST"
                                    id="cancelOrderForm">
                                    @csrf
                                    <button type="button" onclick="confirmCancel()"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 font-poppins">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Informasi Pesanan -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Detail Layanan</h3>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                            <div class="flow-root">
                                <ul role="list" class="-my-5 divide-y divide-gray-200">
                                    @foreach ($order->items as $item)
                                        <li class="py-5">
                                            <div class="flex items-start space-x-4">
                                                <div class="flex-shrink-0">
                                                    @if (isset($item->subJasa->gambar))
                                                        <img class="h-16 w-16 rounded-md object-cover"
                                                            src="{{ Storage::url($item->subJasa->gambar) }}"
                                                            alt="{{ $item->name }}">
                                                    @else
                                                        <div
                                                            class="h-16 w-16 rounded-md bg-gray-200 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-8 w-8 text-gray-400" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium font-poppins text-gray-900">
                                                        {{ $item->name }}</p>
                                                    <p class="text-sm font-roboto text-gray-500">{{ $item->quantity }}
                                                        {{ $item->satuan ?? 'unit' }} x Rp
                                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                                    <p class="text-sm font-semibold font-roboto text-gray-900 mt-1">
                                                        Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>

                                                    @if ($item->tukangProfile)
                                                        <div class="mt-2 flex items-center">
                                                            <span
                                                                class="text-xs font-roboto text-gray-500 mr-2">Teknisi:</span>
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 font-roboto">
                                                                {{ $item->tukangProfile->user->name }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <p class="text-sm font-semibold font-poppins text-gray-900">Rp
                                                        {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Total -->
                                <div class="mt-6 border-t border-gray-200 pt-6">
                                    <div class="flex justify-between">
                                        <p class="text-base font-medium font-poppins text-gray-900">Total</p>
                                        <p class="text-lg font-semibold font-poppins text-gray-900">Rp
                                            {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pelanggan dan Pembayaran -->
                <div class="md:col-span-1 flex flex-col space-y-6">
                    <!-- Informasi Pelanggan -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Informasi Pelanggan</h3>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-1">
                                <div>
                                    <dt class="text-sm font-medium font-roboto text-gray-500">Nama</dt>
                                    <dd class="mt-1 text-sm font-roboto text-gray-900">{{ $order->customer_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium font-roboto text-gray-500">No. Telepon</dt>
                                    <dd class="mt-1 text-sm font-roboto text-gray-900">{{ $order->customer_phone }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium font-roboto text-gray-500">Alamat</dt>
                                    <dd class="mt-1 text-sm font-roboto text-gray-900">{{ $order->customer_address }}</dd>
                                </div>
                                @if ($order->notes)
                                    <div>
                                        <dt class="text-sm font-medium font-roboto text-gray-500">Catatan</dt>
                                        <dd class="mt-1 text-sm font-roboto text-gray-900">{{ $order->notes }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Informasi Pembayaran -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Informasi Pembayaran</h3>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-1">
                                <div>
                                    <dt class="text-sm font-medium font-roboto text-gray-500">Metode Pembayaran</dt>
                                    <dd class="mt-1 text-sm font-roboto text-gray-900">
                                        {{ $order->paymentOption->name ?? 'Tidak tersedia' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium font-roboto text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold font-roboto rounded-full 
                                        @if ($order->payment_status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($order->payment_status == 'verifying') bg-blue-100 text-blue-800 
                                        @elseif($order->payment_status == 'paid') bg-green-100 text-green-800 
                                        @elseif($order->payment_status == 'cancelled') bg-red-100 text-red-800 @endif">
                                            @if ($order->payment_status == 'pending')
                                                Belum Bayar
                                            @elseif($order->payment_status == 'verifying')
                                                Verifikasi
                                            @elseif($order->payment_status == 'paid')
                                                Lunas
                                            @elseif($order->payment_status == 'cancelled')
                                                Dibatalkan
                                            @else
                                                {{ $order->payment_status }}
                                            @endif
                                        </span>
                                    </dd>
                                </div>
                                @if ($order->payment && $order->payment->payment_proof)
                                    <div>
                                        <dt class="text-sm font-medium font-roboto text-gray-500">Bukti Pembayaran</dt>
                                        <dd class="mt-1">
                                            <div class="mt-1 flex items-center">
                                                <a href="{{ Storage::url($order->payment->payment_proof) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-poppins">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Lihat Bukti Pembayaran
                                                </a>
                                            </div>
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Riwayat Status -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50">
                            <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Riwayat Pesanan</h3>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    <li>
                                        <div class="relative pb-8">
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                                aria-hidden="true"></span>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span
                                                        class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm font-roboto text-gray-500">Pesanan dibuat</p>
                                                    </div>
                                                    <div
                                                        class="text-right text-sm whitespace-nowrap font-roboto text-gray-500">
                                                        {{ $order->created_at->format('d M Y H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    @if ($order->payment && $order->payment->created_at)
                                        <li>
                                            <div class="relative pb-8">
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                                    aria-hidden="true"></span>
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span
                                                            class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                            <svg class="h-5 w-5 text-white"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm font-roboto text-gray-500">Pembayaran
                                                                diunggah</p>
                                                        </div>
                                                        <div
                                                            class="text-right text-sm whitespace-nowrap font-roboto text-gray-500">
                                                            {{ $order->payment->created_at->format('d M Y H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    @if ($order->payment && $order->payment->verified_at)
                                        <li>
                                            <div class="relative pb-8">
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                                    aria-hidden="true"></span>
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span
                                                            class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                            <svg class="h-5 w-5 text-white"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm font-roboto text-gray-500">Pembayaran
                                                                diverifikasi</p>
                                                        </div>
                                                        <div
                                                            class="text-right text-sm whitespace-nowrap font-roboto text-gray-500">
                                                            {{ \Carbon\Carbon::parse($order->payment->verified_at)->format('d M Y H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    @if ($order->status == 'completed')
                                        <li>
                                            <div class="relative">
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span
                                                            class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                            <svg class="h-5 w-5 text-white"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm font-roboto text-gray-500">Pesanan selesai
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="text-right text-sm whitespace-nowrap font-roboto text-gray-500">
                                                            {{ $order->updated_at->format('d M Y H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @elseif($order->status == 'cancelled')
                                        <li>
                                            <div class="relative">
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span
                                                            class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                                            <svg class="h-5 w-5 text-white"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm font-roboto text-gray-500">Pesanan dibatalkan
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="text-right text-sm whitespace-nowrap font-roboto text-gray-500">
                                                            {{ $order->updated_at->format('d M Y H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmCancel() {
            Swal.fire({
                title: 'Batalkan Pesanan?',
                text: "Pesanan yang dibatalkan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak, kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancelOrderForm').submit();
                }
            })
        }
    </script>
@endsection
