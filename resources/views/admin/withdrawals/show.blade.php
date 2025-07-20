@extends('layouts.dashboard')

@section('title', 'Detail Withdrawal')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Page header -->
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Detail Withdrawal
                            </h1>
                            <nav class="flex mt-2" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('admin.withdrawals.index') }}"
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
                                            <span class="text-gray-500 ml-1 md:ml-2">Detail</span>
                                        </div>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="flex space-x-2">
                            @if ($withdrawal->status === 'pending')
                                <button onclick="approveWithdrawal()"
                                    class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui
                                </button>
                                <button onclick="rejectWithdrawal()"
                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak
                                </button>
                            @elseif($withdrawal->status === 'approved')
                                <button onclick="completeWithdrawal()"
                                    class="bg-[#F4C542] text-white px-4 py-2 rounded-md hover:bg-[#e0b53d] flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tandai Selesai
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Withdrawal Info -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-medium text-gray-700">Informasi Withdrawal</h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Status</h4>
                                        <span
                                            class="px-3 py-1 text-sm font-semibold rounded-full 
                                            {{ $withdrawal->status === 'completed'
                                                ? 'bg-green-100 text-green-800'
                                                : ($withdrawal->status === 'approved'
                                                    ? 'bg-blue-100 text-blue-800'
                                                    : ($withdrawal->status === 'pending'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : 'bg-red-100 text-red-800')) }}">
                                            @if ($withdrawal->status === 'completed')
                                                Selesai
                                            @elseif($withdrawal->status === 'approved')
                                                Disetujui
                                            @elseif($withdrawal->status === 'pending')
                                                Menunggu
                                            @else
                                                Ditolak
                                            @endif
                                        </span>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Tanggal Pengajuan</h4>
                                        <p class="text-sm text-gray-900">{{ $withdrawal->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Jumlah Withdrawal</h4>
                                        <p class="text-lg font-semibold text-[#332E60]">
                                            Rp{{ number_format($withdrawal->amount, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Biaya Admin</h4>
                                        <p class="text-sm text-gray-900">
                                            Rp{{ number_format($withdrawal->admin_fee, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Total Transfer</h4>
                                        <p class="text-lg font-semibold text-[#F4C542]">
                                            Rp{{ number_format($withdrawal->total_amount, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    @if ($withdrawal->completed_at)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 mb-2">Tanggal Selesai</h4>
                                            <p class="text-sm text-gray-900">
                                                {{ $withdrawal->completed_at->format('d M Y H:i') }}</p>
                                        </div>
                                    @endif

                                    @if ($withdrawal->rejection_reason)
                                        <div class="md:col-span-2">
                                            <h4 class="text-sm font-medium text-gray-500 mb-2">Alasan Penolakan</h4>
                                            <div class="bg-red-50 border border-red-200 rounded p-3">
                                                <p class="text-sm text-red-800">{{ $withdrawal->rejection_reason }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Bank Account Info -->
                        <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-medium text-gray-700">Informasi Rekening</h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Bank</h4>
                                        <p class="text-sm text-gray-900">{{ $withdrawal->bank_name }}</p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Nomor Rekening</h4>
                                        <p class="text-sm text-gray-900 font-mono">{{ $withdrawal->bank_account_number }}
                                        </p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Nama Pemilik</h4>
                                        <p class="text-sm text-gray-900">{{ $withdrawal->bank_account_name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tukang Info -->
                    <div>
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-medium text-gray-700">Informasi Tukang</h3>
                            </div>
                            <div class="p-6">
                                <div class="text-center mb-4">
                                    <div
                                        class="mx-auto h-16 w-16 rounded-full bg-[#332E60] flex items-center justify-center">
                                        <span class="text-white text-xl font-bold">
                                            {{ strtoupper(substr($withdrawal->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <h4 class="mt-2 text-lg font-medium text-gray-900">{{ $withdrawal->user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $withdrawal->user->email }}</p>
                                </div>

                                @if ($withdrawal->user->tukangProfile)
                                    <div class="space-y-3">
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-500">Phone</h5>
                                            <p class="text-sm text-gray-900">{{ $withdrawal->user->phone_number }}</p>
                                        </div>

                                        <div>
                                            <h5 class="text-sm font-medium text-gray-500">Alamat</h5>
                                            <p class="text-sm text-gray-900">{{ $withdrawal->user->address }}</p>
                                        </div>

                                        <div>
                                            <h5 class="text-sm font-medium text-gray-500">Pengalaman</h5>
                                            <p class="text-sm text-gray-900">
                                                {{ $withdrawal->user->tukangProfile->experience }} tahun</p>
                                        </div>

                                        @if ($withdrawal->user->tukangProfile->skills->count() > 0)
                                            <div>
                                                <h5 class="text-sm font-medium text-gray-500 mb-2">Keahlian</h5>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($withdrawal->user->tukangProfile->skills as $skill)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-[#F4C542]/20 text-[#F4C542]">
                                                            {{ $skill->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <a href="{{ route('tukang.show', $withdrawal->user->id) }}"
                                        class="text-[#F4C542] hover:text-[#e0b53d] text-sm font-medium">
                                        Lihat Profil Lengkap →
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Log -->
                        @if ($withdrawal->balanceTransaction)
                            <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
                                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                    <h3 class="text-lg font-medium text-gray-700">Log Transaksi</h3>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500">Type</span>
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $withdrawal->balanceTransaction->type }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500">Deskripsi</span>
                                            <span
                                                class="text-sm text-gray-900">{{ $withdrawal->balanceTransaction->description }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500">Waktu</span>
                                            <span
                                                class="text-sm text-gray-900">{{ $withdrawal->balanceTransaction->created_at->format('d M Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg p-6 w-96">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Withdrawal</h3>
                <form id="rejectForm" method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                        <textarea name="rejection_reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300" required></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeRejectModal()"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function approveWithdrawal() {
            if (confirm('Apakah Anda yakin ingin menyetujui withdrawal ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.withdrawals.approve', $withdrawal) }}';
                form.innerHTML = '@csrf @method('PATCH')';
                document.body.appendChild(form);
                form.submit();
            }
        }

        function rejectWithdrawal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        function completeWithdrawal() {
            if (confirm('Apakah Anda yakin withdrawal ini sudah selesai ditransfer?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.withdrawals.complete', $withdrawal) }}';
                form.innerHTML = '@csrf @method('PATCH')';
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
