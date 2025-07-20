@extends('layouts.dashboard')

@section('title', 'Ajukan Withdrawal')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Page header -->
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Ajukan Withdrawal
                            </h1>
                            <nav class="flex mt-2" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('tukang.withdrawals.index') }}"
                                            class="text-gray-700 hover:text-[#F4C542] inline-flex items-center">
                                            Withdrawal
                                        </a>
                                    </li>
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-gray-500 ml-1 md:ml-2">Ajukan</span>
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
                    <!-- Balance Info Card -->
                    <div class="bg-gradient-to-r from-[#332E60] to-[#4A4473] rounded-lg p-6 text-white mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold">Saldo Anda</h2>
                                <p class="text-3xl font-bold mt-2">
                                    Rp{{ number_format(Auth::user()->withdrawable_balance, 0, ',', '.') }}
                                </p>
                                <p class="text-sm opacity-90 mt-1">Dapat ditarik</p>
                            </div>
                            <div class="text-right">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-50" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-700">Formulir Withdrawal</h3>
                        </div>

                        <form method="POST" action="{{ route('tukang.withdrawals.store') }}" class="p-6"
                            id="withdrawalForm">
                            @csrf

                            <!-- Bank Account Selection -->
                            <div class="mb-6">
                                <label for="bank_account_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Rekening Tujuan <span class="text-red-500">*</span>
                                </label>
                                <select name="bank_account_id" id="bank_account_id" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542] @error('bank_account_id') border-red-300 @enderror">
                                    <option value="">Pilih Rekening</option>
                                    @foreach ($bankAccounts as $account)
                                        <option value="{{ $account->id }}"
                                            {{ old('bank_account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->bank_name }} - {{ $account->account_number }}
                                            ({{ $account->account_holder_name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('bank_account_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div class="mb-6">
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah Withdrawal <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}"
                                        min="{{ $minWithdrawal }}" max="{{ Auth::user()->withdrawable_balance }}"
                                        step="1000" required placeholder="Masukkan jumlah"
                                        class="block w-full pl-12 pr-12 rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542] @error('amount') border-red-300 @enderror">
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">
                                    Minimum: Rp{{ number_format($minWithdrawal, 0, ',', '.') }} -
                                    Maksimum: Rp{{ number_format(Auth::user()->withdrawable_balance, 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Fee Calculation -->
                            <div class="mb-6 bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Rincian Biaya</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span>Jumlah withdrawal:</span>
                                        <span id="withdrawAmount">Rp0</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span>Biaya admin:</span>
                                        <span>Rp{{ number_format($adminFee, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-2">
                                        <div class="flex justify-between text-sm font-medium">
                                            <span>Total yang akan ditransfer:</span>
                                            <span id="totalAmount" class="text-[#F4C542]">Rp0</span>
                                        </div>
                                    </div>
                                </div>
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
                                                <li>Proses withdrawal membutuhkan persetujuan admin</li>
                                                <li>Transfer akan dilakukan dalam 1-2 hari kerja setelah disetujui</li>
                                                <li>Pastikan data rekening bank sudah benar</li>
                                                <li>Withdrawal yang sudah diajukan tidak dapat diubah</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('tukang.withdrawals.index') }}"
                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="bg-[#F4C542] text-white px-4 py-2 rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-[#F4C542]">
                                    Ajukan Withdrawal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        const adminFee = {{ $adminFee }};
        const amountInput = document.getElementById('amount');
        const withdrawAmountSpan = document.getElementById('withdrawAmount');
        const totalAmountSpan = document.getElementById('totalAmount');

        function updateCalculation() {
            const amount = parseInt(amountInput.value) || 0;
            const total = amount + adminFee;

            withdrawAmountSpan.textContent = 'Rp' + amount.toLocaleString('id-ID');
            totalAmountSpan.textContent = 'Rp' + total.toLocaleString('id-ID');
        }

        amountInput.addEventListener('input', updateCalculation);

        // Format number input
        amountInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = value;
            updateCalculation();
        });

        // Validate form before submit
        document.getElementById('withdrawalForm').addEventListener('submit', function(e) {
            const amount = parseInt(amountInput.value) || 0;
            const bankAccountId = document.getElementById('bank_account_id').value;
            const minAmount = {{ $minWithdrawal }};
            const maxAmount = {{ Auth::user()->withdrawable_balance }};

            if (!bankAccountId) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Pilih rekening tujuan terlebih dahulu!',
                    icon: 'error',
                    confirmButtonColor: '#F4C542'
                });
                return;
            }

            if (amount < minAmount) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: `Jumlah minimum withdrawal adalah Rp${minAmount.toLocaleString('id-ID')}`,
                    icon: 'error',
                    confirmButtonColor: '#F4C542'
                });
                return;
            }

            if (amount > maxAmount) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: `Jumlah maksimum withdrawal adalah Rp${maxAmount.toLocaleString('id-ID')}`,
                    icon: 'error',
                    confirmButtonColor: '#F4C542'
                });
                return;
            }

            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Konfirmasi Withdrawal',
                text: `Apakah Anda yakin ingin mengajukan withdrawal sebesar Rp${amount.toLocaleString('id-ID')}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#F4C542',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ajukan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang mengajukan withdrawal',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Remove event listener to avoid recursion
                    e.target.removeEventListener('submit', arguments.callee);

                    // Submit form
                    e.target.submit();
                }
            });

            // Always prevent default to handle with SweetAlert
            e.preventDefault();
        });

        // Initial calculation
        updateCalculation();
    </script>
@endsection
