@extends('layouts.main')
@section('content')

    <body class="bg-gray-100 font-sans">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-7xl w-full flex flex-col md:flex-row">
                <!-- Left side - Image -->
                <div class="md:w-1/2 bg-blue-600 hidden md:block">
                    <img src="{{ asset('images/login-bg.png') }}" alt="Pekerja konstruksi" class="w-full h-full object-cover">
                </div>

                <!-- Right side - Login Form -->
                <div class="md:w-1/2 p-8 md:p-12">
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl font-bold text-gray-800 font-poppins">Selamat Datang!</h2>
                        <p class="text-gray-600 mt-2 font-roboto">Silakan masuk ke akun Anda</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <!-- Email Field -->
                        <div class="mb-6">
                            <label for="email"
                                class="block text-gray-700 text-sm font-medium mb-1 font-poppins">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 font-roboto"
                                placeholder="email@gmail.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-6">
                            <label for="password"
                                class="block text-gray-700 text-sm font-medium mb-1 font-poppins">Password</label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 font-roboto"
                                placeholder="••••••••">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="remember" name="remember"
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="remember" class="ml-2 text-sm text-gray-600 font-roboto">Ingat saya</label>
                            </div>

                            <a href="" class="text-sm text-blue-600 hover:underline font-roboto">
                                Lupa kata sandi?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-[#332E60] text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold font-poppins">
                            Masuk
                        </button>

                        <!-- Register Link -->
                        <div class="text-center mt-6">
                            <p class="text-sm text-gray-600 font-roboto">
                                Belum punya akun?
                                <a href="/register" class="text-blue-600 hover:underline font-medium font-roboto">
                                    Daftar sekarang
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
@endsection
