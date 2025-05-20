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
                                <div class="mt-1 text-3xl font-semibold text-[#332E60]">124</div>
                            </div>
                        </div>
                    </div>

                    <!-- Proyek Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Proyek Aktif</h3>
                                <div class="mt-1 text-3xl font-semibold text-[#332E60]">23</div>
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
                                <h3 class="text-gray-500 text-sm">Pendapatan Bulan Ini</h3>
                                <div class="mt-1 text-3xl font-semibold text-[#332E60]">Rp45.8jt</div>
                            </div>
                        </div>
                    </div>

                    <!-- Konsultasi Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div
                                class="rounded-full h-12 w-12 flex items-center justify-center bg-[#F4C542]/20 text-[#F4C542]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-gray-500 text-sm">Permintaan Konsultasi</h3>
                                <div class="mt-1 text-3xl font-semibold text-[#332E60]">18</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Projects and Activity -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Projects -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-700">Proyek Terbaru</h3>
                        </div>
                        <div class="p-4">
                            <div class="divide-y divide-gray-200">
                                <!-- Project 1 -->
                                <div class="py-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-[#332E60]">Renovasi Rumah Bapak Joko</h4>
                                            <p class="text-xs text-gray-500">Jl. Merdeka No. 123, Jakarta</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktif</span>
                                    </div>
                                    <div class="mt-2 flex justify-between text-xs text-gray-500">
                                        <span>Progress: 65%</span>
                                        <span>Deadline: 20 Mei 2025</span>
                                    </div>
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#F4C542] h-2 rounded-full" style="width: 65%"></div>
                                    </div>
                                </div>

                                <!-- Project 2 -->
                                <div class="py-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-[#332E60]">Konstruksi Gedung Kantor PT ABC
                                            </h4>
                                            <p class="text-xs text-gray-500">Jl. Sudirman, Jakarta Selatan</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktif</span>
                                    </div>
                                    <div class="mt-2 flex justify-between text-xs text-gray-500">
                                        <span>Progress: 30%</span>
                                        <span>Deadline: 15 Juli 2025</span>
                                    </div>
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#F4C542] h-2 rounded-full" style="width: 30%"></div>
                                    </div>
                                </div>

                                <!-- Project 3 -->
                                <div class="py-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-[#332E60]">Instalasi Listrik Ruko Baru</h4>
                                            <p class="text-xs text-gray-500">Jl. Kebon Jeruk, Jakarta Barat</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    </div>
                                    <div class="mt-2 flex justify-between text-xs text-gray-500">
                                        <span>Progress: 15%</span>
                                        <span>Deadline: 5 Juni 2025</span>
                                    </div>
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#F4C542] h-2 rounded-full" style="width: 15%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="text-sm font-medium text-[#F4C542] hover:text-[#e0b53d]">Lihat
                                    semua proyek →</a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-700">Aktivitas Terbaru</h3>
                        </div>
                        <div class="p-4">
                            <ul class="divide-y divide-gray-200">
                                <li class="py-3">
                                    <div class="flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-8 w-8 rounded-full bg-[#332E60] flex items-center justify-center text-white text-xs font-medium">
                                                JD</div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm text-gray-800">
                                                <a href="#" class="font-medium text-[#332E60]">John Doe</a>
                                                mendaftar sebagai tukang baru
                                            </p>
                                            <p class="text-xs text-gray-500">30 menit yang lalu</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-3">
                                    <div class="flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-8 w-8 rounded-full bg-[#332E60] flex items-center justify-center text-white text-xs font-medium">
                                                AS</div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm text-gray-800">
                                                <a href="#" class="font-medium text-[#332E60]">Ani Suryani</a>
                                                mengajukan permintaan konsultasi baru
                                            </p>
                                            <p class="text-xs text-gray-500">2 jam yang lalu</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-3">
                                    <div class="flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-8 w-8 rounded-full bg-[#332E60] flex items-center justify-center text-white text-xs font-medium">
                                                BW</div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm text-gray-800">
                                                <a href="#" class="font-medium text-[#332E60]">Budi Winarno</a>
                                                menyelesaikan proyek "Renovasi Dapur"
                                            </p>
                                            <p class="text-xs text-gray-500">Kemarin, 16:42</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-3">
                                    <div class="flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-8 w-8 rounded-full bg-[#332E60] flex items-center justify-center text-white text-xs font-medium">
                                                RS</div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm text-gray-800">
                                                <a href="#" class="font-medium text-[#332E60]">Rini Susanti</a>
                                                memberikan ulasan 5 bintang untuk proyek "Instalasi Listrik"
                                            </p>
                                            <p class="text-xs text-gray-500">Kemarin, 10:30</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <a href="#" class="text-sm font-medium text-[#F4C542] hover:text-[#e0b53d]">Lihat
                                    semua aktivitas →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions and Todo List -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-700 mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#"
                                class="bg-[#332E60] text-white p-4 rounded-lg flex items-center justify-center hover:bg-[#282356] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                <span>Tambah Pengguna</span>
                            </a>
                            <a href="#"
                                class="bg-[#332E60] text-white p-4 rounded-lg flex items-center justify-center hover:bg-[#282356] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                <span>Buat Laporan</span>
                            </a>
                            <a href="#"
                                class="bg-[#332E60] text-white p-4 rounded-lg flex items-center justify-center hover:bg-[#282356] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Tambah Proyek</span>
                            </a>
                            <a href="#"
                                class="bg-[#332E60] text-white p-4 rounded-lg flex items-center justify-center hover:bg-[#282356] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Jadwalkan</span>
                            </a>
                        </div>
                    </div>

                    <!-- Todo List -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-700 mb-4">Tugas Hari Ini</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input id="todo1" type="checkbox"
                                    class="h-4 w-4 text-[#F4C542] focus:ring-[#F4C542] border-gray-300 rounded">
                                <label for="todo1" class="ml-3 block text-sm text-gray-700">Review permintaan
                                    konsultasi baru (5)</label>
                            </div>
                            <div class="flex items-center">
                                <input id="todo2" type="checkbox"
                                    class="h-4 w-4 text-[#F4C542] focus:ring-[#F4C542] border-gray-300 rounded">
                                <label for="todo2" class="ml-3 block text-sm text-gray-700">Konfirmasi pembayaran
                                    proyek Gedung XYZ</label>
                            </div>
                            <div class="flex items-center">
                                <input id="todo3" type="checkbox"
                                    class="h-4 w-4 text-[#F4C542] focus:ring-[#F4C542] border-gray-300 rounded" checked>
                                <label for="todo3" class="ml-3 block text-sm text-gray-500 line-through">Update status
                                    proyek renovasi kantor</label>
                            </div>
                            <div class="flex items-center">
                                <input id="todo4" type="checkbox"
                                    class="h-4 w-4 text-[#F4C542] focus:ring-[#F4C542] border-gray-300 rounded">
                                <label for="todo4" class="ml-3 block text-sm text-gray-700">Follow-up klien untuk
                                    proyek baru</label>
                            </div>
                            <div class="flex items-center">
                                <input id="todo5" type="checkbox"
                                    class="h-4 w-4 text-[#F4C542] focus:ring-[#F4C542] border-gray-300 rounded">
                                <label for="todo5" class="ml-3 block text-sm text-gray-700">Review laporan
                                    bulanan</label>
                            </div>
                        </div>
                        <div class="mt-4 flex">
                            <input type="text"
                                class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring focus:ring-[#F4C542] focus:ring-opacity-20"
                                placeholder="Tambah tugas baru...">
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md shadow-sm text-white bg-[#F4C542] hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
