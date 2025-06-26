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
                        @if ($order->status === 'processing')
                            <div>
                                <button type="button" id="completeOrderBtn"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Tandai Selesai
                                </button>
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

    <!-- Modal untuk konfirmasi menyelesaikan order -->
    <div id="completeOrderModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Menyelesaikan Pesanan</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menandai pesanan ini sebagai selesai? Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <div class="mt-4">
                        <label for="completion_notes"
                            class="block text-sm font-medium text-left text-gray-700 mb-1">Catatan Penyelesaian
                            (Opsional)</label>
                        <textarea id="completion_notes" name="completion_notes" rows="3"
                            class="shadow-sm focus:ring-[#332E60] focus:border-[#332E60] mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2"></textarea>
                    </div>
                </div>
                <div class="flex justify-between px-4 py-3">
                    <button id="cancelCompleteBtn" type="button"
                        class="bg-gray-200 px-4 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none">
                        Batal
                    </button>
                    <form id="completeOrderForm" action="{{ route('tukang.pesanan.complete', $order->id) }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="completion_notes" id="form_completion_notes">
                        <button type="submit"
                            class="bg-green-600 px-4 py-2 rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none">
                            Konfirmasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const completeOrderBtn = document.getElementById('completeOrderBtn');
            const completeOrderModal = document.getElementById('completeOrderModal');
            const cancelCompleteBtn = document.getElementById('cancelCompleteBtn');
            const completionNotes = document.getElementById('completion_notes');
            const formCompletionNotes = document.getElementById('form_completion_notes');

            if (completeOrderBtn) {
                completeOrderBtn.addEventListener('click', function() {
                    completeOrderModal.classList.remove('hidden');
                });
            }

            if (cancelCompleteBtn) {
                cancelCompleteBtn.addEventListener('click', function() {
                    completeOrderModal.classList.add('hidden');
                    completionNotes.value = '';
                });
            }

            const completeOrderForm = document.getElementById('completeOrderForm');
            if (completeOrderForm) {
                completeOrderForm.addEventListener('submit', function() {
                    formCompletionNotes.value = completionNotes.value;
                });
            }
        });
    </script>
@endsection
