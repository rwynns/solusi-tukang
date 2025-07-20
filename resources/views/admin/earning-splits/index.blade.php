@extends('layouts.dashboard')

@section('title', 'Kelola Pembagian Pendapatan')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Page header -->
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Pembagian Pendapatan
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Total Admin Earnings -->
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
                                <h3 class="text-gray-500 text-sm">Total Pendapatan Admin</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($totalAdminEarnings, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Admin Earnings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Admin Bulan Ini</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($monthlyAdminEarnings, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Tukang Earnings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="rounded-full h-12 w-12 flex items-center justify-center bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Total Pendapatan Tukang</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($totalTukangEarnings, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Tukang Earnings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-purple-100 text-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Tukang Bulan Ini</h3>
                                <div class="mt-1 text-2xl font-semibold text-[#332E60]">
                                    Rp{{ number_format($monthlyTukangEarnings, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <form method="GET" action="{{ route('admin.earning-splits.index') }}"
                        class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="tukang_id" class="block text-sm font-medium text-gray-700">Tukang</label>
                            <select name="tukang_id" id="tukang_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542]">
                                <option value="">Semua Tukang</option>
                                @foreach ($tukangs as $tukang)
                                    <option value="{{ $tukang->id }}"
                                        {{ request('tukang_id') == $tukang->id ? 'selected' : '' }}>
                                        {{ $tukang->name }}
                                    </option>
                                @endforeach
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

                        <div class="md:col-span-3 flex justify-end space-x-2">
                            <button type="submit"
                                class="bg-[#F4C542] text-white px-4 py-2 rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-[#F4C542]">
                                Filter
                            </button>
                            <a href="{{ route('admin.earning-splits.index') }}"
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
                            <h3 class="text-sm font-medium text-blue-800">Informasi Pembagian</h3>
                            <div class="mt-1 text-sm text-blue-700">
                                <p>• Platform mengambil <strong>10%</strong> dari setiap transaksi sebagai biaya operasional
                                </p>
                                <p>• Tukang mendapatkan <strong>90%</strong> dari total pembayaran customer</p>
                                <p>• Pembagian otomatis dilakukan saat customer menyelesaikan pembayaran</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earning Splits Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-700">Daftar Pembagian Pendapatan</h3>
                    </div>

                    @if ($splits->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Order ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tukang</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Order</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Platform (10%)</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tukang (90%)</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($splits as $split)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-[#332E60]">
                                                    #{{ $split->order->order_number }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $split->order->customer_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $split->tukang ? $split->tukang->name : 'Belum ditentukan' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    Rp{{ number_format($split->total_amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-[#F4C542]">
                                                    Rp{{ number_format($split->admin_amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-green-600">
                                                    Rp{{ number_format($split->tukang_amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $split->created_at->format('d M Y H:i') }}
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
                                    Menampilkan {{ $splits->firstItem() }} - {{ $splits->lastItem() }} dari
                                    {{ $splits->total() }} data
                                </div>
                                {{ $splits->withQueryString()->links() }}
                            </div>
                        </div>

                        <!-- Summary Footer -->
                        <div class="px-6 py-4 border-t border-gray-200 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center">
                                    <div class="text-sm text-gray-600">Total Order</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        Rp{{ number_format($splits->sum('total_amount'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm text-gray-600">Total Platform (10%)</div>
                                    <div class="text-lg font-semibold text-[#F4C542]">
                                        Rp{{ number_format($splits->sum('admin_amount'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm text-gray-600">Total Tukang (90%)</div>
                                    <div class="text-lg font-semibold text-green-600">
                                        Rp{{ number_format($splits->sum('tukang_amount'), 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            Tidak ada data pembagian pendapatan.
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
@endsection
