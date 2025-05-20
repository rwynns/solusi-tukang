@extends('layouts.dashboard')

@section('title', 'Tambah Tukang')

@section('content')
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Tambah Tukang</h1>
                <a href="{{ route('tukang.index') }}"
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
                    <form action="{{ route('tukang.store') }}" method="POST" enctype="multipart/form-data">
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
                            <div class="col-span-1">
                                <label for="name" class="block mb-1 text-sm font-medium font-poppins">Nama
                                    Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>
                            </div>

                            <div class="col-span-1">
                                <label for="email" class="block mb-1 text-sm font-medium font-poppins">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>
                            </div>

                            <div class="col-span-1">
                                <label for="password" class="block mb-1 text-sm font-medium font-poppins">Password</label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>
                                <p class="mt-1 text-xs text-gray-500 font-roboto">Minimal 8 karakter</p>
                            </div>

                            <div class="col-span-1">
                                <label for="password_confirmation"
                                    class="block mb-1 text-sm font-medium font-poppins">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>
                            </div>

                            <div class="col-span-1">
                                <label for="phone_number" class="block mb-1 text-sm font-medium font-poppins">Nomor
                                    Telepon</label>
                                <input type="text" name="phone_number" id="phone_number"
                                    value="{{ old('phone_number') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>
                                <p class="mt-1 text-xs text-gray-500 font-roboto">Contoh: 081234567890</p>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="address" class="block mb-1 text-sm font-medium font-poppins">Alamat</label>
                                <textarea name="address" id="address" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>{{ old('address') }}</textarea>
                            </div>

                            <div class="col-span-1">
                                <label for="location_id" class="block mb-1 text-sm font-medium font-poppins">Lokasi</label>
                                <select name="location_id" id="location_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>
                                    <option value="">Pilih Lokasi</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}"
                                            {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="skills" class="block mb-1 text-sm font-medium font-poppins">Keahlian</label>
                                <div class="border border-gray-300 rounded-lg p-3 bg-white">
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                        @foreach ($skills as $skill)
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input id="skill_{{ $skill->id }}" name="skills[]" type="checkbox"
                                                        value="{{ $skill->id }}"
                                                        {{ in_array($skill->id, old('skills', [])) ? 'checked' : '' }}
                                                        class="focus:ring-[#332E60] h-4 w-4 text-[#332E60] border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="skill_{{ $skill->id }}"
                                                        class="font-medium text-gray-700">{{ $skill->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 font-roboto">Pilih minimal satu keahlian</p>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="bio" class="block mb-1 text-sm font-medium font-poppins">Bio /
                                    Deskripsi</label>
                                <textarea name="bio" id="bio" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto">{{ old('bio') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500 font-roboto">Deskripsikan pengalaman dan keahlian
                                    tukang secara singkat</p>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="profile_photo" class="block mb-1 text-sm font-medium font-poppins">Foto
                                    Profil</label>
                                <div class="mt-1 flex items-center space-x-5">
                                    <span class="inline-block h-24 w-24 rounded-full overflow-hidden bg-gray-100"
                                        id="photo_preview">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24"
                                            id="default_avatar">
                                            <path
                                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <img id="preview_image" src="#" alt="Preview"
                                            class="h-full w-full object-cover hidden">
                                    </span>

                                    <div class="relative">
                                        <input type="file" name="profile_photo" id="profile_photo"
                                            accept="image/jpeg,image/png,image/jpg"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Pilih Foto
                                        </button>
                                        <p id="selected_file_name" class="mt-2 text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 font-roboto">Format: JPG, PNG. Maks: 2MB</p>
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
            // Fungsi untuk menampilkan preview foto
            const photoInput = document.getElementById('profile_photo');
            const previewImage = document.getElementById('preview_image');
            const defaultAvatar = document.getElementById('default_avatar');
            const selectedFileName = document.getElementById('selected_file_name');

            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    // Cek apakah file adalah gambar
                    if (!file.type.match('image.*')) {
                        alert('File harus berupa gambar (JPG, PNG)');
                        return;
                    }

                    // Cek ukuran file (max 2MB = 2 * 1024 * 1024 bytes)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran gambar terlalu besar. Maksimal 2MB.');
                        return;
                    }

                    // Tampilkan nama file
                    selectedFileName.textContent = file.name;

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Tampilkan preview dan sembunyikan avatar default
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');
                        defaultAvatar.classList.add('hidden');
                    }

                    reader.readAsDataURL(file);
                } else {
                    // Jika tidak ada file, tampilkan avatar default
                    previewImage.classList.add('hidden');
                    defaultAvatar.classList.remove('hidden');
                    selectedFileName.textContent = '';
                }
            });
        });
    </script>
@endsection
