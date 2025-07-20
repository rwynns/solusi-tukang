@extends('layouts.dashboard')

@section('title', 'Tambah Rekening Bank')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Page header -->
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Tambah Rekening Bank
                            </h1>
                            <nav class="flex mt-2" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('tukang.bank-accounts.index') }}"
                                            class="text-gray-700 hover:text-[#F4C542] inline-flex items-center">
                                            Rekening Bank
                                        </a>
                                    </li>
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-gray-500 ml-1 md:ml-2">Tambah</span>
                                        </div>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

                <div class="max-w-2xl mx-auto">
                    <!-- Form Card -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-700">Informasi Rekening Bank</h3>
                        </div>

                        <form method="POST" action="{{ route('tukang.bank-accounts.store') }}" class="p-6">
                            @csrf

                            <!-- Bank Name -->
                            <div class="mb-6">
                                <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Bank <span class="text-red-500">*</span>
                                </label>
                                <select name="bank_name" id="bank_name" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542] @error('bank_name') border-red-300 @enderror">
                                    <option value="">Pilih Bank</option>
                                    @foreach ($bankList as $bank)
                                        <option value="{{ $bank }}"
                                            {{ old('bank_name') === $bank ? 'selected' : '' }}>
                                            {{ $bank }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bank_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Account Number -->
                            <div class="mb-6">
                                <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Rekening <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="account_number" id="account_number"
                                    value="{{ old('account_number') }}" required placeholder="Masukkan nomor rekening"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542] @error('account_number') border-red-300 @enderror">
                                @error('account_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Masukkan nomor rekening tanpa spasi atau tanda baca
                                </p>
                            </div>

                            <!-- Account Name -->
                            <div class="mb-6">
                                <label for="account_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Pemilik Rekening <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="account_name" id="account_name"
                                    value="{{ old('account_name') }}" required placeholder="Nama sesuai rekening bank"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542] @error('account_name') border-red-300 @enderror">
                                @error('account_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Pastikan nama sesuai dengan yang tertera di rekening
                                    bank</p>
                            </div>

                            <!-- Info Box -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mt-0.5 mr-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <h3 class="text-sm font-medium text-blue-800">Penting!</h3>
                                        <div class="mt-1 text-sm text-blue-700">
                                            <ul class="list-disc list-inside space-y-1">
                                                <li>Setiap tukang hanya bisa memiliki 1 rekening bank aktif</li>
                                                <li>Pastikan semua data rekening sudah benar</li>
                                                <li>Rekening harus atas nama Anda sendiri</li>
                                                <li>Rekening ini akan digunakan untuk menerima pembayaran withdrawal</li>
                                                <li>Untuk mengganti bank, hapus rekening ini lalu buat yang baru</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('tukang.bank-accounts.index') }}"
                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="bg-[#F4C542] text-white px-4 py-2 rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-[#F4C542]">
                                    Simpan Rekening
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Format account number input
        document.getElementById('account_number').addEventListener('input', function(e) {
            // Remove all non-numeric characters
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // Validate form before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const bankName = document.getElementById('bank_name').value;
            const accountNumber = document.getElementById('account_number').value;
            const accountName = document.getElementById('account_name').value;

            if (!bankName || !accountNumber || !accountName) {
                e.preventDefault();
                alert('Semua field harus diisi!');
                return;
            }

            if (accountNumber.length < 8) {
                e.preventDefault();
                alert('Nomor rekening terlalu pendek!');
                return;
            }
        });
    </script>
@endsection
