@extends('layouts.main')
@section('content')
    <div class="bg-gray-100 py-12">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-7xl w-full flex flex-col md:flex-row">
                <!-- Left side - Image -->
                <div class="md:w-1/2 bg-blue-600 hidden md:block">
                    <img src="{{ asset('images/login-bg.png') }}" alt="Pekerja konstruksi" class="w-full h-full object-cover">
                </div>

                <!-- Right side - Registration Form -->
                <div class="md:w-1/2 p-6 md:p-8">
                    <div class="mb-4 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 font-poppins">Buat Akun Baru</h2>
                        <p class="text-gray-600 text-sm mt-1 font-roboto">Daftar untuk mendapatkan layanan terbaik</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Field -->
                            <div class="mb-3">
                                <label for="name" class="block text-gray-700 text-sm font-medium mb-1 font-poppins">Nama
                                    Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="w-full px-3 py-2 border font-roboto border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Field -->
                            <div class="mb-3">
                                <label for="phone"
                                    class="block text-gray-700 text-sm font-medium mb-1 font-poppins">Nomor
                                    Telepon</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                    class="w-full px-3 py-2 border font-roboto border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="block text-gray-700 text-sm font-medium mb-1 font-poppins">Alamat
                                Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-3 py-2 border font-roboto border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="email@anda.com">
                            <p class="text-xs text-gray-500 mt-1">Email akan digunakan untuk verifikasi akun Anda</p>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address Field -->
                        <div class="mb-3">
                            <label for="address"
                                class="block text-gray-700 text-sm font-medium mb-1 font-poppins">Alamat</label>
                            <textarea id="address" name="address" rows="2" required
                                class="w-full px-3 py-2 border font-roboto border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="block text-gray-700 text-sm font-medium mb-1 font-poppins">Kata
                                    Sandi</label>
                                <input type="password" id="password" name="password" required
                                    class="w-full px-3 py-2 border font-roboto border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Minimal 8 karakter">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div class="mb-3">
                                <label for="password_confirmation"
                                    class="block text-gray-700 text-sm font-medium mb-1 font-poppins">Konfirmasi Kata
                                    Sandi</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full px-3 py-2 border font-roboto border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan ulang kata sandi">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-poppins py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold mt-2 cursor-pointer">
                            Daftar Sekarang
                        </button>

                        <div
                            class="flex flex-col sm:flex-row sm:justify-between items-center mt-4 text-center sm:text-left">
                            <!-- Verification Info -->
                            <p class="text-xs text-gray-500 mb-2 sm:mb-0 sm:w-3/5 font-roboto">
                                Dengan mendaftar, Anda akan menerima email verifikasi
                            </p>

                            <!-- Login Link -->
                            <p class="text-sm text-gray-600 sm:text-right sm:w-2/5 font-roboto">
                                Sudah punya akun?
                                <a href="" class="text-blue-600 hover:underline font-medium font-roboto">
                                    Masuk
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
