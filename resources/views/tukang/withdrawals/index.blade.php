@extends('layouts.dashboard')

@section('title', 'Withdrawal Saya')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Page header -->
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Withdrawal Saya
                            </h1>
                            <p class="mt-1 text-sm text-gray-600">Kelola penarikan saldo Anda</p>
                        </div>
                        <div>
                            @if ($stats['withdrawable_balance'] >= 50000)
                                <a href="{{ route('tukang.withdrawals.create') }}"
                                    class="bg-[#F4C542] text-white px-4 py-2 rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-[#F4C542] flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Ajukan Withdrawal
                                </a>
                            @else
                                <button disabled
                                    class="bg-gray-400 text-white px-4 py-2 rounded-md cursor-not-allowed flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 15.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    Saldo Tidak Mencukupi
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

                <!-- Balance Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Available Balance -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Saldo Tersedia</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($stats['available_balance'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

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
                                <h3 class="text-gray-500 text-sm">Pending Withdrawal</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($stats['pending_withdrawals'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Withdrawable Balance -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Dapat Ditarik</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($stats['withdrawable_balance'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Withdrawn -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="rounded-full h-12 w-12 flex items-center justify-center bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Total Ditarik</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($stats['total_withdrawn'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <p>• Proses transfer: <strong>1-2 hari kerja</strong> setelah disetujui</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Withdrawals Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-700">Riwayat Withdrawal</h3>
                    </div>

                    @if ($withdrawals->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Bank Tujuan</th>
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
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($withdrawals as $withdrawal)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $withdrawal->created_at->format('d M Y') }}</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $withdrawal->created_at->format('H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $withdrawal->bankAccount->bank_name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $withdrawal->bankAccount->account_number }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $withdrawal->bankAccount->account_holder_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    Rp{{ number_format($withdrawal->requested_amount, 0, ',', '.') }}
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
                                                                : ($withdrawal->status === 'cancelled'
                                                                    ? 'bg-gray-100 text-gray-800'
                                                                    : 'bg-red-100 text-red-800'))) }}">
                                                    @if ($withdrawal->status === 'completed')
                                                        Selesai
                                                    @elseif($withdrawal->status === 'approved')
                                                        Disetujui
                                                    @elseif($withdrawal->status === 'pending')
                                                        Menunggu
                                                    @elseif($withdrawal->status === 'cancelled')
                                                        Dibatalkan
                                                    @else
                                                        Ditolak
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    @if ($withdrawal->status === 'pending')
                                                        <button onclick="cancelWithdrawal({{ $withdrawal->id }})"
                                                            class="text-red-600 hover:text-red-900">Batalkan</button>
                                                    @endif
                                                </div>
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
                                {{ $withdrawals->links() }}
                            </div>
                        </div>
                    @else
                        <div class="p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada withdrawal</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai ajukan withdrawal pertama Anda ketika saldo
                                mencukupi.</p>
                            @if ($stats['withdrawable_balance'] >= 50000)
                                <div class="mt-6">
                                    <a href="{{ route('tukang.withdrawals.create') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#F4C542] hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Ajukan Withdrawal
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        function cancelWithdrawal(id) {
            if (confirm('Apakah Anda yakin ingin membatalkan withdrawal ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/tukang/withdrawal/${id}/cancel`;
                form.innerHTML = '@csrf @method('PATCH')';
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
