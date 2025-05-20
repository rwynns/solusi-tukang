@extends('layouts.dashboard')

@section('title', 'Tambah Jasa')

@section('content')
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Tambah Jasa</h1>
                <a href="{{ route('kelola-jasa.index') }}"
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
        <div class="max-w-5xl mx-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('kelola-jasa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

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

                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="nama" class="block mb-1 text-sm font-medium font-poppins">Nama Jasa</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="slug" class="block mb-1 text-sm font-medium font-poppins">Slug (URL)</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                        solusi-tukang.com/jasa/
                                    </span>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                        class="flex-1 min-w-0 block w-full px-3 py-2 border border-gray-300 rounded-none rounded-r-md bg-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                        disabled>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 font-roboto">Slug akan dibuat otomatis dari nama jasa
                                </p>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="deskripsi" class="block mb-1 text-sm font-medium font-poppins">Deskripsi
                                    Jasa</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>{{ old('deskripsi') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500 font-roboto">Jelaskan detail layanan yang ditawarkan
                                </p>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="gambar" class="block mb-1 text-sm font-medium font-poppins">Gambar
                                    Jasa</label>
                                <div class="mt-1 flex items-center space-x-5">
                                    <span class="inline-block h-40 w-64 overflow-hidden bg-gray-100 rounded-lg"
                                        id="photo_preview">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24"
                                            id="default_image">
                                            <path
                                                d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z" />
                                        </svg>
                                        <img id="preview_image" src="#" alt="Preview"
                                            class="h-full w-full object-cover hidden">
                                    </span>

                                    <div class="relative">
                                        <input type="file" name="gambar" id="gambar"
                                            accept="image/jpeg,image/png,image/jpg"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Pilih Gambar
                                        </button>
                                        <p id="selected_file_name" class="mt-2 text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 font-roboto">Format: JPG, PNG. Maks: 2MB. Ukuran
                                    terbaik: 600x400px.</p>
                            </div>
                        </div>

                        <div class="pt-5 mt-4 border-t border-gray-200">
                            <div class="flex justify-end">
                                <button type="button" onclick="window.history.back()"
                                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-semibold font-poppins text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60] mr-3 cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-[#332E60] py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold font-poppins text-white hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60] cursor-pointer">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-preview slug from name (but don't set the value since it's disabled)
            const namaInput = document.getElementById('nama');
            const slugInput = document.getElementById('slug');

            namaInput.addEventListener('input', function() {
                // Simple slug generator - convert to lowercase and replace spaces with hyphens
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special chars
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-'); // Remove consecutive hyphens

                // Just show as preview, don't set value since it's disabled
                slugInput.value = slug;
            });

            // Fungsi untuk menampilkan preview gambar
            const imageInput = document.getElementById('gambar');
            const previewImage = document.getElementById('preview_image');
            const defaultImage = document.getElementById('default_image');
            const selectedFileName = document.getElementById('selected_file_name');

            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    // Cek apakah file adalah gambar
                    if (!file.type.match('image.*')) {
                        alert('File harus berupa gambar (JPG, PNG)');
                        return;
                    }

                    // Cek ukuran file (max 2MB = 2 * 1024 * 1024 bytes)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran gambar terlalu besar. Maksimal 5MB.');
                        return;
                    }

                    // Tampilkan nama file
                    selectedFileName.textContent = file.name;

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Tampilkan preview dan sembunyikan avatar default
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');
                        defaultImage.classList.add('hidden');
                    }

                    reader.readAsDataURL(file);
                } else {
                    // Jika tidak ada file, tampilkan default image
                    previewImage.classList.add('hidden');
                    defaultImage.classList.remove('hidden');
                    selectedFileName.textContent = '';
                }
            });
        });
    </script>
@endsection
