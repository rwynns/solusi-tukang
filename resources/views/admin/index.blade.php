@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

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
                            <span class="text-sm text-gray-500">Selamat datang, {{ Auth::user()->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Pengguna Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Total Pengguna</h3>
                                <div class="mt-1 text-3xl font-semibold text-[#332E60]">{{ \App\Models\User::count() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tukang Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Total Tukang</h3>
                                <div class="mt-1 text-3xl font-semibold text-[#332E60]">
                                    {{ \App\Models\TukangProfile::count() }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Pendapatan Card -->
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
                                <h3 class="text-gray-500 text-sm">Pendapatan Admin Bulan Ini</h3>
                                <div class="mt-1 text-3xl font-semibold text-[#332E60]">
                                    @php
                                        $adminEarnings = \App\Models\EarningSplit::getTotalAdminEarnings('month');
                                    @endphp
                                    Rp{{ number_format($adminEarnings / 1000000, 1) }}jt
                                </div>
                                <div class="mt-1 text-xs text-gray-400">
                                    (10% dari total pembayaran)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pesanan Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Pesanan Aktif</h3>
                                <div class="mt-1 text-3xl font-semibold text-[#332E60]">
                                    {{ \App\Models\Order::where('status', 'processing')->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-700">Pesanan Terbaru</h3>
                    </div>
                    <div class="p-4">
                        <div class="divide-y divide-gray-200">
                            @php
                                $recentOrders = \App\Models\Order::with(['user', 'items.subJasa'])
                                    ->latest()
                                    ->take(3)
                                    ->get();

                                // Define order status colors and progress percentages
                                $orderStatusColors = [
                                    'pending' => [
                                        'bg' => 'bg-yellow-100',
                                        'text' => 'text-yellow-800',
                                        'progress' => '25%',
                                    ],
                                    'processing' => [
                                        'bg' => 'bg-blue-100',
                                        'text' => 'text-blue-800',
                                        'progress' => '50%',
                                    ],
                                    'completed' => [
                                        'bg' => 'bg-green-100',
                                        'text' => 'text-green-800',
                                        'progress' => '100%',
                                    ],
                                    'cancelled' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-800',
                                        'progress' => '0%',
                                    ],
                                ];
                            @endphp

                            @forelse($recentOrders as $order)
                                @php
                                    $statusInfo = $orderStatusColors[$order->status] ?? $orderStatusColors['pending'];
                                @endphp
                                <div class="py-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-[#332E60]">
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="hover:text-[#F4C542]">
                                                    Order #{{ $order->order_number }}
                                                </a>
                                            </h4>
                                            <p class="text-xs text-gray-500">{{ $order->customer_name }} -
                                                {{ $order->customer_phone }}</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $statusInfo['bg'] }} {{ $statusInfo['text'] }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="mt-2 flex justify-between text-xs text-gray-500">
                                        <span>Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline-block mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $order->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#F4C542] h-2 rounded-full"
                                            style="width: {{ $statusInfo['progress'] }}"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-3 text-center text-gray-500">
                                    Belum ada pesanan
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.orders.index') }}"
                                class="text-sm font-medium text-[#F4C542] hover:text-[#e0b53d]">Lihat semua pesanan →</a>
                        </div>
                    </div>
                </div>

                <!-- Earning Splits Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                    <!-- Earning Statistics -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-700">Statistik Pendapatan</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $totalAdminMonth = \App\Models\EarningSplit::getTotalAdminEarnings('month');
                                $totalTukangMonth = \App\Models\EarningSplit::getTotalTukangEarnings(null, 'month');
                                $totalEarningsMonth = $totalAdminMonth + $totalTukangMonth;

                                $totalAdminAll = \App\Models\EarningSplit::getTotalAdminEarnings();
                                $totalTukangAll = \App\Models\EarningSplit::getTotalTukangEarnings();
                                $totalEarningsAll = $totalAdminAll + $totalTukangAll;
                            @endphp

                            <div class="space-y-4">
                                <!-- Bulan Ini -->
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-600">Bulan Ini</span>
                                        <span class="text-sm font-semibold text-[#332E60]">
                                            Rp{{ number_format($totalEarningsMonth, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-gray-500">Admin (10%)</span>
                                            <span class="text-[#F4C542] font-medium">
                                                Rp{{ number_format($totalAdminMonth, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between text-xs">
                                            <span class="text-gray-500">Tukang (90%)</span>
                                            <span class="text-green-600 font-medium">
                                                Rp{{ number_format($totalTukangMonth, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                        @if ($totalEarningsMonth > 0)
                                            <div class="h-2 rounded-full flex">
                                                <div class="bg-[#F4C542] rounded-l-full"
                                                    style="width: {{ ($totalAdminMonth / $totalEarningsMonth) * 100 }}%">
                                                </div>
                                                <div class="bg-green-500 rounded-r-full"
                                                    style="width: {{ ($totalTukangMonth / $totalEarningsMonth) * 100 }}%">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Total Keseluruhan -->
                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-600">Total Keseluruhan</span>
                                        <span class="text-sm font-semibold text-[#332E60]">
                                            Rp{{ number_format($totalEarningsAll, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-gray-500">Admin (10%)</span>
                                            <span class="text-[#F4C542] font-medium">
                                                Rp{{ number_format($totalAdminAll, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between text-xs">
                                            <span class="text-gray-500">Tukang (90%)</span>
                                            <span class="text-green-600 font-medium">
                                                Rp{{ number_format($totalTukangAll, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                        @if ($totalEarningsAll > 0)
                                            <div class="h-2 rounded-full flex">
                                                <div class="bg-[#F4C542] rounded-l-full"
                                                    style="width: {{ ($totalAdminAll / $totalEarningsAll) * 100 }}%">
                                                </div>
                                                <div class="bg-green-500 rounded-r-full"
                                                    style="width: {{ ($totalTukangAll / $totalEarningsAll) * 100 }}%">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Earning Splits -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-700">Pembagian Pendapatan Terbaru</h3>
                        </div>
                        <div class="p-4">
                            <div class="space-y-3">
                                @php
                                    $recentSplits = \App\Models\EarningSplit::with(['order', 'tukang'])
                                        ->latest()
                                        ->take(5)
                                        ->get();
                                @endphp

                                @forelse($recentSplits as $split)
                                    <div class="border border-gray-200 rounded-lg p-3">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-sm font-medium text-[#332E60]">
                                                    Order #{{ $split->order->order_number }}
                                                </h4>
                                                <p class="text-xs text-gray-500">
                                                    {{ $split->tukang ? $split->tukang->name : 'Belum ditentukan' }}
                                                </p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                Dibagi Otomatis
                                            </span>
                                        </div>
                                        <div class="mt-2 grid grid-cols-3 gap-2 text-xs">
                                            <div class="text-center">
                                                <div class="text-gray-500">Total</div>
                                                <div class="font-medium text-[#332E60]">
                                                    Rp{{ number_format($split->total_amount, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-gray-500">Admin</div>
                                                <div class="font-medium text-[#F4C542]">
                                                    Rp{{ number_format($split->admin_amount, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-gray-500">Tukang</div>
                                                <div class="font-medium text-green-600">
                                                    Rp{{ number_format($split->tukang_amount, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2 text-xs text-gray-400">
                                            {{ $split->created_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-gray-500 py-4">
                                        Belum ada pembagian pendapatan
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
