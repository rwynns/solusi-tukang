@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Verifikasi Email</h2>
                    <p class="text-gray-600 mt-2">Silakan periksa email Anda untuk link verifikasi</p>
                </div>

                @if (session('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('message') }}</p>
                    </div>
                @endif

                <p class="text-gray-700 mb-6">
                    Sebelum melanjutkan, harap periksa email Anda untuk tautan verifikasi.
                    Jika Anda tidak menerima email, Anda dapat meminta tautan baru dengan mengklik tombol di bawah ini.
                </p>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        Kirim Ulang Link Verifikasi
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
