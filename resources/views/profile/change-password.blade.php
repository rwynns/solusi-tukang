@extends('layouts.main')

@section('content')
    <div class="py-32 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold font-poppins text-gray-900">Ganti Password</h1>
                <p class="mt-2 text-gray-600 font-roboto">Perbarui password akun anda untuk menjaga keamanan</p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Left Side - Profile Picture and Menu -->
                <div class="md:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow mb-4">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900 font-poppins mb-1">{{ Auth::user()->name }}</h2>
                            <p class="text-gray-600 mb-4 font-roboto">{{ ucfirst(Auth::user()->role->name) }}</p>
                        </div>

                        <div class="mt-6 space-y-3">
                            <a href="{{ route('profile') }}"
                                class="block w-full px-4 py-2 text-center border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-all font-poppins">
                                Profil
                            </a>
                            <a href="{{ route('profile.password') }}"
                                class="block w-full px-4 py-2 text-center bg-[#332E60] text-white rounded-md hover:bg-[#2A2655] transition-all font-poppins">
                                Ubah Password
                            </a>
                            <a href="{{ route('customer.orders.index') }}"
                                class="block w-full px-4 py-2 text-center border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-all font-poppins">
                                Pesanan Saya
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Change Password Form -->
                <div class="md:col-span-3">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 font-poppins">Ganti Password</h2>
                        </div>

                        <div class="p-6">

                            <form action="{{ route('profile.password.update') }}" method="POST">
                                @csrf
                                <div class="mb-5">
                                    <label for="current_password"
                                        class="block text-gray-700 font-medium font-roboto mb-2">Password Saat
                                        Ini</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#332E60] focus:border-[#332E60]">
                                    @error('current_password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="password" class="block text-gray-700 font-medium font-roboto mb-2">Password
                                        Baru</label>
                                    <input type="password" name="password" id="password"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#332E60] focus:border-[#332E60]">
                                    <p class="text-gray-500 text-xs mt-1">Password minimal 8 karakter</p>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="password_confirmation"
                                        class="block text-gray-700 font-medium font-roboto mb-2">Konfirmasi
                                        Password Baru</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#332E60] focus:border-[#332E60]">
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-2 bg-[#332E60] text-white font-medium rounded-md shadow-sm hover:bg-[#2A2655] transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542] font-poppins">
                                        Perbarui Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
