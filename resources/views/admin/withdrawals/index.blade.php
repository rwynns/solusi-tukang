@extends('layouts.dashboard')

@section('title', 'Kelola Withdrawal')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Page header -->
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Kelola Withdrawal
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Pending Withdrawals -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-yellow-100 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Pending</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    {{ $stats['total_pending'] }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    Rp{{ number_format($stats['pending_amount'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Approved Withdrawals -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="rounded-full h-12 w-12 flex items-center justify-center bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Approved</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    {{ $stats['total_approved'] }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Withdrawals -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Completed</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    {{ $stats['total_completed'] }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Completed -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Bulan Ini</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($stats['monthly_completed'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <form method="GET" action="{{ route('admin.withdrawals.index') }}"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542]">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="md:col-span-3 flex justify-end space-x-2">
                            <button type="submit"
                                class="bg-[#F4C542] text-white px-4 py-2 rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-[#F4C542]">
                                Filter
                            </button>
                            <a href="{{ route('admin.withdrawals.index') }}"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Summary Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="ml-2">
                            <h3 class="text-sm font-medium text-blue-800">Informasi Withdrawal</h3>
                            <div class="mt-1 text-sm text-blue-700">
                                <p>• Minimum withdrawal: <strong>Rp 50,000</strong></p>
                                <p>• Biaya admin: <strong>Rp 2,500</strong> per withdrawal</p>
                                <p>• Status "Approved" siap untuk diproses transfer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Withdrawals Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-700">Daftar Withdrawal</h3>
                        <div class="flex space-x-2">
                            <button onclick="openBatchModal()"
                                class="bg-[#F4C542] text-white px-4 py-2 rounded-md text-sm hover:bg-[#e0b53d] flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                Batch Process
                            </button>
                        </div>
                    </div>

                    @if ($withdrawals->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tukang</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Bank</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total + Fee</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($withdrawals as $withdrawal)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="withdrawal_ids[]"
                                                    value="{{ $withdrawal->id }}"
                                                    class="withdrawal-checkbox rounded border-gray-300">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-[#332E60]">
                                                    {{ $withdrawal->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $withdrawal->user->email }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $withdrawal->bank_name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $withdrawal->bank_account_number }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $withdrawal->bank_account_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    Rp{{ number_format($withdrawal->amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-[#F4C542]">
                                                    Rp{{ number_format($withdrawal->total_amount, 0, ',', '.') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    (Fee: Rp{{ number_format($withdrawal->admin_fee, 0, ',', '.') }})
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $withdrawal->created_at->format('d M Y H:i') }}
                                                @if ($withdrawal->completed_at)
                                                    <br><small class="text-green-600">Selesai:
                                                        {{ $withdrawal->completed_at->format('d M Y') }}</small>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('admin.withdrawals.show', $withdrawal) }}"
                                                    class="text-blue-600 hover:text-blue-900">Detail</a>

                                                @if ($withdrawal->status === 'pending')
                                                    <button onclick="approveWithdrawal({{ $withdrawal->id }})"
                                                        class="text-green-600 hover:text-green-900">Setujui</button>
                                                    <button onclick="rejectWithdrawal({{ $withdrawal->id }})"
                                                        class="text-red-600 hover:text-red-900">Tolak</button>
                                                @elseif($withdrawal->status === 'approved')
                                                    <button onclick="completeWithdrawal({{ $withdrawal->id }})"
                                                        class="text-[#F4C542] hover:text-[#e0b53d]">Selesai</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    Menampilkan {{ $withdrawals->firstItem() }} - {{ $withdrawals->lastItem() }} dari
                                    {{ $withdrawals->total() }} data
                                </div>
                                {{ $withdrawals->withQueryString()->links() }}
                            </div>
                        </div>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            Tidak ada data withdrawal.
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Batch Process Modal -->
    <div id="batchModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg p-6 w-96">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Batch Process Withdrawal</h3>
                <form id="batchForm" method="POST" action="{{ route('admin.withdrawals.batch-process') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Aksi</label>
                        <select name="action" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="approve">Setujui</option>
                            <option value="complete">Selesaikan</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeBatchModal()"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-[#F4C542] text-white px-4 py-2 rounded">Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg p-6 w-96">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Withdrawal</h3>
                <form id="rejectForm" method="POST">
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
        // Select all functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.withdrawal-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        function openBatchModal() {
            const selected = document.querySelectorAll('.withdrawal-checkbox:checked');
            if (selected.length === 0) {
                alert('Pilih minimal satu withdrawal untuk diproses.');
                return;
            }
            document.getElementById('batchModal').classList.remove('hidden');
        }

        function closeBatchModal() {
            document.getElementById('batchModal').classList.add('hidden');
        }

        document.getElementById('batchForm').addEventListener('submit', function(e) {
            const selected = document.querySelectorAll('.withdrawal-checkbox:checked');
            selected.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'withdrawal_ids[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });
        });

        function approveWithdrawal(id) {
            if (confirm('Apakah Anda yakin ingin menyetujui withdrawal ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/withdrawals/${id}/approve`;
                form.innerHTML = '@csrf @method('PATCH')';
                document.body.appendChild(form);
                form.submit();
            }
        }

        function rejectWithdrawal(id) {
            document.getElementById('rejectForm').action = `/admin/withdrawals/${id}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        function completeWithdrawal(id) {
            if (confirm('Apakah Anda yakin withdrawal ini sudah selesai ditransfer?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/withdrawals/${id}/complete`;
                form.innerHTML = '@csrf @method('PATCH')';
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
