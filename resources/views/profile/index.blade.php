@extends('layouts.main')

@section('content')
    <div class="py-32 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold font-poppins text-gray-900">Profil Saya</h1>
                <p class="mt-2 text-gray-600 font-roboto">Kelola informasi akun dan pengaturan profil anda</p>
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
                            <h2 class="text-xl font-semibold text-gray-900 font-poppins mb-1">{{ $user->name }}</h2>
                            <p class="text-gray-600 mb-4 font-roboto">{{ ucfirst($user->role->name) }}</p>
                        </div>

                        <div class="mt-6 space-y-3">
                            <a href="{{ route('profile') }}"
                                class="block w-full px-4 py-2 text-center bg-[#332E60] text-white rounded-md hover:bg-[#2A2655] transition-all font-poppins">
                                Profil
                            </a>
                            <a href="{{ route('profile.password') }}"
                                class="block w-full px-4 py-2 text-center border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-all font-poppins">
                                Ubah Password
                            </a>
                            <a href="{{ route('customer.orders.index') }}"
                                class="block w-full px-4 py-2 text-center border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-all font-poppins">
                                Pesanan Saya
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Profile Form -->
                <div class="md:col-span-3">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 font-poppins">Data Diri</h2>
                        </div>

                        <div class="p-6">

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                <div class="mb-5">
                                    <label for="name" class="block text-gray-700 font-medium font-roboto mb-2">Nama
                                        Lengkap</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#332E60] focus:border-[#332E60]">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="email"
                                        class="block text-gray-700 font-medium font-roboto mb-2">Email</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#332E60] focus:border-[#332E60]">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="phone_number" class="block text-gray-700 font-medium font-roboto mb-2">Nomor
                                        Telepon</label>
                                    <input type="text" name="phone_number" id="phone_number"
                                        value="{{ old('phone_number', $user->phone_number) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#332E60] focus:border-[#332E60]">
                                    @error('phone_number')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="address"
                                        class="block text-gray-700 font-medium font-roboto mb-2">Alamat</label>
                                    <textarea name="address" id="address" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#332E60] focus:border-[#332E60]">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-2 bg-[#332E60] text-white font-medium rounded-md shadow-sm hover:bg-[#2A2655] transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542] font-poppins">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
