@extends('layouts.dashboard')

@section('title', 'Dashboard Tukang')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Page header -->
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-500">Selamat datang, {{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
                <div class="max-w-7xl mx-auto">
                    <!-- Statistik Utama -->
                    <div class="mb-8">
                        <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">Statistik Pesanan</h2>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <!-- Kartu Total Pesanan -->
                            <div class="bg-white rounded-lg shadow p-6">
                                <div class="flex items-center">
                                    <div
                                        class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75c0-.23.031-.447.095-.657C19.016 3.089 18.167 2.25 17.08 2.25h-4.18c.463 1.02 1.086 1.597 1.703 2.105" />
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <h3 class="text-gray-500 text-sm">Total Pesanan</h3>
                                        <div class="mt-1 text-3xl font-semibold text-[#332E60]">
                                            {{ $stats['total_orders'] ?? 0 }}</div>
                                    </div>
                                </div>
                                <div class="mt-4 text-sm">
                                    <a href="{{ route('tukang.pesanan.index') }}"
                                        class="font-medium text-[#F4C542] hover:text-yellow-500">Lihat semua pesanan</a>
                                </div>
                            </div>

                            <!-- Kartu Pesanan Aktif -->
                            <div class="bg-white rounded-lg shadow p-6">
                                <div class="flex items-center">
                                    <div
                                        class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <h3 class="text-gray-500 text-sm">Pesanan Aktif</h3>
                                        <div class="mt-1 text-3xl font-semibold text-[#332E60]">
                                            {{ $stats['active_orders'] ?? 0 }}</div>
                                    </div>
                                </div>
                                <div class="mt-4 text-sm">
                                    <a href="{{ route('tukang.pesanan.index', ['status' => 'processing']) }}"
                                        class="font-medium text-[#F4C542] hover:text-yellow-500">Lihat pesanan aktif</a>
                                </div>
                            </div>

                            <!-- Kartu Pesanan Selesai -->
                            <div class="bg-white rounded-lg shadow p-6">
                                <div class="flex items-center">
                                    <div
                                        class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <h3 class="text-gray-500 text-sm">Pesanan Selesai</h3>
                                        <div class="mt-1 text-3xl font-semibold text-[#332E60]">
                                            {{ $stats['completed_orders'] ?? 0 }}</div>
                                    </div>
                                </div>
                                <div class="mt-4 text-sm">
                                    <a href="{{ route('tukang.pesanan.index', ['status' => 'completed']) }}"
                                        class="font-medium text-[#F4C542] hover:text-yellow-500">Lihat riwayat pesanan</a>
                                </div>
                            </div>

                            <!-- Kartu Penghasilan -->
                            <div class="bg-white rounded-lg shadow p-6">
                                <div class="flex items-center">
                                    <div
                                        class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <h3 class="text-gray-500 text-sm">Pendapatan Saya (90%)</h3>
                                        <div class="mt-1 text-3xl font-semibold text-[#332E60]">Rp
                                            {{ number_format($stats['total_earnings'] ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="mt-4 text-sm">
                                    <a href="{{ route('tukang.earnings.index') }}"
                                        class="font-medium text-[#F4C542] hover:text-yellow-500">Lihat rincian
                                        penghasilan</a>
                                    <br>
                                    <span class="font-medium text-gray-500">Bulan Ini: Rp
                                        {{ number_format($stats['monthly_earnings'] ?? 0, 0, ',', '.') }}</span>
                                    <br>
                                    <small class="text-gray-400">90% dari total pembayaran customer</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Pesanan Terbaru -->
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg leading-6 font-medium text-gray-900">Pesanan Terbaru</h2>
                                    <a href="{{ route('tukang.pesanan.index') }}"
                                        class="text-sm font-medium text-[#F4C542] hover:text-yellow-500">
                                        Lihat semua
                                    </a>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    No. Pesanan
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Tanggal
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($recent_orders ?? [] as $order)
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $order->order_number }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $order->created_at->format('d M Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('tukang.pesanan.show', $order) }}"
                                                            class="text-[#F4C542] hover:text-yellow-500">
                                                            Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4"
                                                        class="px-6 py-4 text-center text-sm text-gray-500">
                                                        Belum ada pesanan
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Profil dan Layanan -->
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg leading-6 font-medium text-gray-900">Informasi Profil</h2>
                                    <a href="{{ route('tukang.profile') }}"
                                        class="text-sm font-medium text-[#F4C542] hover:text-yellow-500">
                                        Lihat profil
                                    </a>
                                </div>

                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-16 w-16 rounded-full overflow-hidden bg-gray-100 border-2 border-[#F3BD2B]">
                                            @if (Auth::user()->tukangProfile && Auth::user()->tukangProfile->profile_photo)
                                                <img src="{{ asset('storage/' . Auth::user()->tukangProfile->profile_photo) }}"
                                                    alt="Profile" class="h-full w-full object-cover">
                                            @else
                                                <div
                                                    class="h-full w-full bg-[#F3BD2B] flex items-center justify-center text-xl text-white font-bold">
                                                    {{ substr(Auth::user()->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                                        <p class="text-sm text-gray-500">
                                            {{ Auth::user()->tukangProfile && Auth::user()->tukangProfile->location ? Auth::user()->tukangProfile->location->name : 'Lokasi belum diatur' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-6 border-t border-gray-200 pt-4">
                                    <h3 class="text-md font-medium text-gray-900 mb-3">Layanan yang Anda Tawarkan</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @if (Auth::user()->tukangProfile && Auth::user()->tukangProfile->skills->isNotEmpty())
                                            @foreach (Auth::user()->tukangProfile->skills as $skill)
                                                <span class="px-2 py-1 text-xs rounded-full bg-[#332E60] text-white">
                                                    {{ $skill->nama }}
                                                </span>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-500">Belum ada layanan yang Anda tawarkan. <a
                                                    href="{{ route('tukang.profile.edit') }}"
                                                    class="text-[#F4C542] hover:text-yellow-500 underline">Tambahkan
                                                    sekarang</a>.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('tukang.profile.edit') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#F4C542] hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Edit Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Pendapatan -->
                    <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg leading-6 font-medium text-gray-900">Riwayat Pendapatan</h2>
                            </div>

                            @if (isset($earning_splits) && $earning_splits->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Order
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Total Pembayaran
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Pendapatan Saya (90%)
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Tanggal
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($earning_splits as $split)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            #{{ $split->order->order_number }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $split->order->customer_name }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            Rp{{ number_format($split->total_amount, 0, ',', '.') }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-green-600">
                                                            Rp{{ number_format($split->tukang_amount, 0, ',', '.') }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            {{ $split->status === 'distributed'
                                                                ? 'bg-green-100 text-green-800'
                                                                : ($split->status === 'pending'
                                                                    ? 'bg-yellow-100 text-yellow-800'
                                                                    : 'bg-red-100 text-red-800') }}">
                                                            @if ($split->status === 'distributed')
                                                                Sudah Dibayar
                                                            @elseif($split->status === 'pending')
                                                                Menunggu
                                                            @else
                                                                Ditahan
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $split->created_at->format('d M Y') }}
                                                        @if ($split->distributed_at)
                                                            <br><small class="text-green-600">
                                                                Dibayar: {{ $split->distributed_at->format('d M Y') }}
                                                            </small>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4 text-center">
                                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                        <div class="flex">
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-blue-800">
                                                    Informasi Pembagian Pendapatan
                                                </h3>
                                                <div class="mt-2 text-sm text-blue-700">
                                                    <p>• Anda mendapat <strong>90%</strong> dari total pembayaran customer
                                                    </p>
                                                    <p>• Admin mendapat <strong>10%</strong> sebagai biaya platform</p>
                                                    <p>• Pembayaran akan diproses setelah pesanan selesai</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat pendapatan</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Pendapatan akan muncul setelah Anda menyelesaikan pesanan.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        @endsection
