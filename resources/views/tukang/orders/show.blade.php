@extends('layouts.dashboard')

@section('title', 'Detail Pesanan')

@section('content')
    <!-- Page header -->
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold font-poppins text-gray-900">Detail Pesanan</h1>
                    <p class="mt-1 text-sm text-gray-500">Order #{{ $order->order_number }}</p>
                </div>
                <div>
                    <a href="{{ route('tukang.pesanan.index') }}"
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
            <!-- BARIS 1: Status Pemesanan dan Informasi Customer -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Status Pemesanan -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 flex justify-between">
                        <div>
                            <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Status Pemesanan</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Tanggal Pemesanan:
                                {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @if ($order->status === 'processing' && $order->payment_status === 'paid')
                            <div>
                                @if (!$order->tukang_confirmed)
                                    <form action="{{ route('tukang.pesanan.confirm-completion', $order) }}" method="POST"
                                        id="confirmCompletionForm">
                                        @csrf
                                        <button type="button" onclick="confirmCompletion()"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-4 w-4"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Konfirmasi Selesai
                                        </button>
                                    </form>
                                @else
                                    <div
                                        class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-green-700 bg-green-100 border border-green-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-4 w-4"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Anda sudah konfirmasi selesai
                                        @if (!$order->customer_confirmed)
                                            <span class="ml-2 text-xs">(Menunggu customer)</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
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

                        @if ($order->status === 'processing' && $order->payment_status === 'paid')
                            <div class="bg-blue-50 px-4 py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-6">
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 mb-2">Status Konfirmasi Penyelesaian</dt>
                                    <dd class="mt-1 grid grid-cols-1 gap-2">
                                        <div class="flex items-center">
                                            @if ($order->customer_confirmed)
                                                <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-sm text-green-700 font-medium">Customer sudah konfirmasi
                                                    selesai</span>
                                            @else
                                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 001.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-sm text-gray-500">Customer belum konfirmasi selesai</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center">
                                            @if ($order->tukang_confirmed)
                                                <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-sm text-green-700 font-medium">Anda sudah konfirmasi
                                                    selesai</span>
                                            @else
                                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 001.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-sm text-gray-500">Anda belum konfirmasi selesai</span>
                                            @endif
                                        </div>
                                    </dd>
                                </div>
                            </div>
                        @endif

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
                                    <a href="tel:{{ $order->customer_phone }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $order->customer_phone }}
                                    </a>
                                </dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="mailto:{{ $order->user->email }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $order->user->email }}
                                    </a>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- BARIS 2: Detail Jasa (Lebar Penuh) -->
            <div class="mb-6">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 flex justify-between">
                        <div>
                            <h3 class="text-lg leading-6 font-medium font-poppins text-gray-900">Detail Jasa</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Jasa yang akan Anda kerjakan</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jasa
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Teknisi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if ($order->orderItems && count($order->orderItems) > 0)
                                        @foreach ($order->orderItems as $item)
                                            @if ($item->tukangProfile && $item->tukangProfile->id === Auth::user()->tukangProfile->id)
                                                <tr class="bg-blue-50">
                                                @else
                                                <tr>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $item->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if ($item->tukangProfile)
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-8 w-8">
                                                            <img class="h-8 w-8 rounded-full"
                                                                src="{{ $item->tukangProfile->profile_photo ? asset('storage/' . $item->tukangProfile->profile_photo) : asset('images/default-avatar.png') }}"
                                                                alt="{{ $item->tukangProfile->user->name }}">
                                                        </div>
                                                        <div class="ml-3">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $item->tukangProfile->user->name }}
                                                            </div>
                                                            @if ($item->tukangProfile->id === Auth::user()->tukangProfile->id)
                                                                <div class="text-xs text-green-600">
                                                                    Anda
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-yellow-600 text-xs">Belum ditugaskan</span>
                                                @endif
                                            </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Tidak ada item untuk pesanan ini
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('scripts')
    <script>
        function confirmCompletion() {
            Swal.fire({
                title: 'Konfirmasi Penyelesaian',
                text: "Apakah Anda yakin pekerjaan sudah selesai dikerjakan?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, sudah selesai!',
                cancelButtonText: 'Belum'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('confirmCompletionForm').submit();
                }
            })
        }
    </script>
@endsection
