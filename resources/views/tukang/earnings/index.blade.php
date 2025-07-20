@extends('layouts.dashboard')

@section('title', 'Penghasilan Saya')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Page header -->
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Penghasilan Saya</h1>
                            <p class="text-sm text-gray-600 mt-1">Monitor total pendapatan dan rincian order yang telah
                                diselesaikan</p>
                        </div>
                        <a href="{{ route('tukang.dashboard') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Total Earnings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Total Pendapatan</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($totalEarnings, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Earnings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="rounded-full h-12 w-12 flex items-center justify-center bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Bulan Ini</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($monthlyEarnings, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Earnings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Hari Ini</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($todayEarnings, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Earnings -->
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
                                <h3 class="text-gray-500 text-sm">Menunggu Pembayaran</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($pendingEarnings, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Panel -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="ml-2">
                            <h3 class="text-sm font-medium text-blue-800">Informasi Pendapatan</h3>
                            <div class="mt-1 text-sm text-blue-700">
                                <p>• Anda mendapatkan <strong>90%</strong> dari setiap transaksi yang diselesaikan</p>
                                <p>• Platform mengambil <strong>10%</strong> sebagai biaya operasional dan maintenance</p>
                                <p>• Status "Distributed" berarti pembayaran sudah dapat ditarik</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <form method="GET" action="{{ route('tukang.earnings.index') }}"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542]">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="distributed" {{ request('status') === 'distributed' ? 'selected' : '' }}>
                                    Distributed</option>
                                <option value="held" {{ request('status') === 'held' ? 'selected' : '' }}>Held</option>
                            </select>
                        </div>

                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542]">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542]">
                        </div>

                        <div class="flex items-end">
                            <div class="flex space-x-2">
                                <button type="submit"
                                    class="bg-[#F4C542] text-white px-4 py-2 rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-[#F4C542]">
                                    Filter
                                </button>
                                <a href="{{ route('tukang.earnings.index') }}"
                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Earnings Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-700">Rincian Pendapatan</h3>
                    </div>

                    @if ($earnings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Order</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Customer</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Layanan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Order</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pendapatan Saya (90%)</th>
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
                                    @foreach ($earnings as $earning)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-[#332E60]">
                                                    #{{ $earning->order->order_number }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $earning->order->customer_name }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $earning->order->customer_phone }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @if ($earning->order->orderItems->count() > 0)
                                                        @php
                                                            $firstItem = $earning->order->orderItems->first();
                                                            $serviceName =
                                                                $firstItem->subJasa->nama ??
                                                                ($firstItem->name ?? 'Layanan tidak ditemukan');
                                                        @endphp
                                                        {{ $serviceName }}
                                                        @if ($earning->order->orderItems->count() > 1)
                                                            <span
                                                                class="text-gray-500">+{{ $earning->order->orderItems->count() - 1 }}
                                                                lainnya</span>
                                                        @endif
                                                    @else
                                                        <span class="text-gray-500">Tidak ada layanan</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    Rp{{ number_format($earning->total_amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-green-600">
                                                    Rp{{ number_format($earning->tukang_amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $earning->status === 'distributed'
                                                        ? 'bg-green-100 text-green-800'
                                                        : ($earning->status === 'pending'
                                                            ? 'bg-yellow-100 text-yellow-800'
                                                            : 'bg-red-100 text-red-800') }}">
                                                    @if ($earning->status === 'distributed')
                                                        Sudah Dibayar
                                                    @elseif($earning->status === 'pending')
                                                        Menunggu
                                                    @else
                                                        Ditahan
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $earning->created_at->format('d M Y') }}
                                                @if ($earning->distributed_at)
                                                    <br><small class="text-green-600">Dibayar:
                                                        {{ $earning->distributed_at->format('d M Y') }}</small>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('tukang.earnings.show', $earning->id) }}"
                                                    class="text-[#F4C542] hover:text-[#e0b53d]">Detail</a>
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
                                    Menampilkan {{ $earnings->firstItem() }} - {{ $earnings->lastItem() }} dari
                                    {{ $earnings->total() }} data
                                </div>
                                {{ $earnings->withQueryString()->links() }}
                            </div>
                        </div>

                        <!-- Summary Footer -->
                        <div class="px-6 py-4 border-t border-gray-200 bg-green-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="text-center">
                                    <div class="text-sm text-gray-600">Total Order (Halaman Ini)</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        Rp{{ number_format($earnings->sum('total_amount'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm text-gray-600">Total Pendapatan Saya (Halaman Ini)</div>
                                    <div class="text-lg font-semibold text-green-600">
                                        Rp{{ number_format($earnings->sum('tukang_amount'), 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pendapatan</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai ambil order untuk mendapatkan pendapatan pertama
                                Anda.</p>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
@endsection
