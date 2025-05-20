@extends('layouts.dashboard')

@section('title', 'Edit Keahlian')

@section('content')
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-lg">Edit Keahlian</h1>
                <a href="{{ route('skills.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium font-poppins rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6">
                        <path fill-rule="evenodd"
                            d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z"
                            clip-rule="evenodd" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Main content area -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-100">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('skills.update', $skill) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
                                <p class="font-bold">Terjadi kesalahan:</p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="name" class="block mb-1 text-sm font-medium font-poppins">Nama
                                Keahlian</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $skill->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                required>
                            <p class="mt-1 text-xs text-gray-500 font-roboto">Contoh: Konstruksi Rumah Tinggal, Renovasi
                                Rumah, Jasa
                                Desain Interior, dsb.
                            </p>
                        </div>

                        <div class="pt-5">
                            <div class="flex justify-end">
                                <button type="button" onclick="window.history.back()"
                                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-semibold font-poppins text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60] mr-3 cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-[#332E60] py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold font-poppins text-white hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60] cursor-pointer">
                                    Perbarui
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
