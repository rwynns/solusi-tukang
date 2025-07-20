@extends('layouts.dashboard')

@section('title', 'Edit Pembagian Pendapatan')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Page header -->
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Edit Pembagian Pendapatan</h1>
                            <p class="text-sm text-gray-600">Order #{{ $earningSplit->order->order_number }}</p>
                        </div>
                        <a href="{{ route('admin.earning-splits.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

                <div class="max-w-2xl mx-auto">
                    <!-- Order Info -->
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pesanan</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Pesanan</label>
                                <p class="text-sm text-gray-900">#{{ $earningSplit->order->order_number }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer</label>
                                <p class="text-sm text-gray-900">{{ $earningSplit->order->customer_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Pembayaran</label>
                                <p class="text-sm text-gray-900">
                                    Rp{{ number_format($earningSplit->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                                <p class="text-sm text-gray-900">{{ ucfirst($earningSplit->order->payment_status) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Earning Split Details -->
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Pembagian</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-[#F4C542]/10 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700">Bagian Admin
                                    ({{ $earningSplit->admin_percentage }}%)</label>
                                <p class="text-lg font-semibold text-[#F4C542]">
                                    Rp{{ number_format($earningSplit->admin_amount, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700">Bagian Tukang
                                    ({{ $earningSplit->tukang_percentage }}%)</label>
                                <p class="text-lg font-semibold text-green-600">
                                    Rp{{ number_format($earningSplit->tukang_amount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Pembagian Pendapatan</h3>

                        <form method="POST" action="{{ route('admin.earning-splits.update', $earningSplit) }}">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <!-- Tukang Selection -->
                                <div>
                                    <label for="tukang_id" class="block text-sm font-medium text-gray-700">Tukang</label>
                                    <select name="tukang_id" id="tukang_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542] @error('tukang_id') border-red-300 @enderror">
                                        <option value="">Pilih Tukang</option>
                                        @foreach ($tukangs as $tukang)
                                            <option value="{{ $tukang->id }}"
                                                {{ old('tukang_id', $earningSplit->tukang_id) == $tukang->id ? 'selected' : '' }}>
                                                {{ $tukang->name }}
                                                @if ($tukang->tukangProfile)
                                                    -
                                                    {{ $tukang->tukangProfile->specialization ?? 'Spesialisasi belum diset' }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tukang_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542] @error('status') border-red-300 @enderror">
                                        <option value="pending"
                                            {{ old('status', $earningSplit->status) == 'pending' ? 'selected' : '' }}>
                                            Pending - Menunggu distribusi
                                        </option>
                                        <option value="distributed"
                                            {{ old('status', $earningSplit->status) == 'distributed' ? 'selected' : '' }}>
                                            Distributed - Sudah didistribusikan
                                        </option>
                                        <option value="held"
                                            {{ old('status', $earningSplit->status) == 'held' ? 'selected' : '' }}>
                                            Held - Ditahan
                                        </option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <textarea name="notes" id="notes" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542] @error('notes') border-red-300 @enderror"
                                        placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes', $earningSplit->notes) }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Current Status Info -->
                                @if ($earningSplit->distributed_at)
                                    <div class="bg-green-50 border border-green-200 rounded-md p-4">
                                        <div class="flex">
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-green-800">
                                                    Status Distribusi
                                                </h3>
                                                <div class="mt-2 text-sm text-green-700">
                                                    <p>Didistribusikan pada:
                                                        {{ $earningSplit->distributed_at->format('d M Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Submit Button -->
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.earning-splits.index') }}"
                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                        Batal
                                    </a>
                                    <button type="submit"
                                        class="bg-[#F4C542] text-white px-4 py-2 rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-[#F4C542]">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
