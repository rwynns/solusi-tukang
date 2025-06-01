@extends('layouts.dashboard')

@section('title', 'Edit Payment Option')

@section('content')
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Edit Payment Option</h1>
                <a href="{{ route('payment-options.index') }}"
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
                    <form action="{{ route('payment-options.update', $paymentOption->id) }}" method="POST"
                        enctype="multipart/form-data">
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

                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="name" class="block mb-1 text-sm font-medium font-poppins">Nama Payment
                                    Option</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $paymentOption->name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>
                                <p class="mt-1 text-xs text-gray-500 font-roboto">Contoh: Bank BCA, DANA, OVO, ShopeePay</p>
                            </div>

                            <div class="sm:col-span-1">
                                <label for="account_number" class="block mb-1 text-sm font-medium font-poppins">Nomor
                                    Rekening/Akun</label>
                                <input type="text" name="account_number" id="account_number"
                                    value="{{ old('account_number', $paymentOption->account_number) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>
                                <p class="mt-1 text-xs text-gray-500 font-roboto">Nomor rekening bank atau nomor akun
                                    e-wallet</p>
                            </div>

                            <div class="sm:col-span-1">
                                <label for="account_name" class="block mb-1 text-sm font-medium font-poppins">Nama Pemilik
                                    Rekening/Akun</label>
                                <input type="text" name="account_name" id="account_name"
                                    value="{{ old('account_name', $paymentOption->account_name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500 font-roboto"
                                    required>
                                <p class="mt-1 text-xs text-gray-500 font-roboto">Nama pemilik rekening bank atau akun
                                    e-wallet</p>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="logo" class="block mb-1 text-sm font-medium font-poppins">Logo Payment
                                    Option</label>
                                <div class="mt-1 flex items-center space-x-5">
                                    <span class="inline-block h-40 w-40 overflow-hidden bg-gray-100 rounded-lg"
                                        id="logo_preview">
                                        @if ($paymentOption->logo)
                                            <img src="{{ Storage::url($paymentOption->logo) }}" alt="Logo"
                                                class="h-full w-full object-contain" id="preview_logo">
                                        @else
                                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24"
                                                id="default_logo">
                                                <path
                                                    d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z" />
                                            </svg>
                                        @endif
                                    </span>

                                    <div class="relative">
                                        <input type="file" name="logo" id="logo"
                                            accept="image/jpeg,image/png,image/jpg,image/gif"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $paymentOption->logo ? 'Ganti Logo' : 'Pilih Logo' }}
                                        </button>
                                        <p id="selected_logo_name" class="mt-2 text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 font-roboto">Format: JPG, PNG, GIF. Maks: 2MB. Logo
                                    metode pembayaran.</p>
                                @if ($paymentOption->logo)
                                    <p class="mt-1 text-xs text-gray-500 font-roboto">Biarkan kosong jika tidak ingin
                                        mengubah logo.</p>
                                @endif
                            </div>

                            <div class="sm:col-span-2">
                                <label for="qr_code" class="block mb-1 text-sm font-medium font-poppins">QR Code
                                    (Opsional)</label>
                                <div class="mt-1 flex items-center space-x-5">
                                    <span class="inline-block h-40 w-40 overflow-hidden bg-gray-100 rounded-lg"
                                        id="qr_preview">
                                        @if ($paymentOption->qr_code)
                                            <img src="{{ Storage::url($paymentOption->qr_code) }}" alt="QR Code"
                                                class="h-full w-full object-contain" id="preview_qr">
                                        @else
                                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24"
                                                id="default_qr">
                                                <path
                                                    d="M3 11h8V3H3v8zm2-6h4v4H5V5zM3 21h8v-8H3v8zm2-6h4v4H5v-4zM13 3v8h8V3h-8zm6 6h-4V5h4v4zM13 13h2v2h-2zM15 15h2v2h-2zM13 17h2v2h-2zM17 17h2v2h-2zM19 19h2v2h-2zM15 19h2v2h-2zM17 13h2v2h-2zM19 15h2v2h-2z" />
                                            </svg>
                                        @endif
                                    </span>

                                    <div class="relative">
                                        <input type="file" name="qr_code" id="qr_code"
                                            accept="image/jpeg,image/png,image/jpg,image/gif"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $paymentOption->qr_code ? 'Ganti QR Code' : 'Pilih QR Code' }}
                                        </button>
                                        <p id="selected_qr_name" class="mt-2 text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 font-roboto">Format: JPG, PNG, GIF. Maks: 2MB. QR Code
                                    untuk pembayaran.</p>
                                @if ($paymentOption->qr_code)
                                    <p class="mt-1 text-xs text-gray-500 font-roboto">Biarkan kosong jika tidak ingin
                                        mengubah QR code.</p>
                                @endif
                            </div>

                            <div class="sm:col-span-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                        {{ $paymentOption->is_active ? 'checked' : '' }}
                                        class="h-4 w-4 text-[#332E60] focus:ring-[#332E60] border-gray-300 rounded">
                                    <label for="is_active"
                                        class="ml-2 block text-sm font-medium font-poppins text-gray-700">
                                        Aktif
                                    </label>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 font-roboto">Payment option yang aktif akan
                                    ditampilkan kepada pelanggan</p>
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
                                    Simpan Perubahan
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
            // Fungsi untuk menampilkan preview logo
            const logoInput = document.getElementById('logo');
            const previewLogo = document.getElementById('preview_logo');
            const defaultLogo = document.getElementById('default_logo');
            const selectedLogoName = document.getElementById('selected_logo_name');

            logoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    // Cek apakah file adalah gambar
                    if (!file.type.match('image.*')) {
                        alert('File harus berupa gambar (JPG, PNG, GIF)');
                        return;
                    }

                    // Cek ukuran file (max 2MB = 2 * 1024 * 1024 bytes)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran gambar terlalu besar. Maksimal 2MB.');
                        return;
                    }

                    // Tampilkan nama file
                    selectedLogoName.textContent = file.name;

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Tampilkan preview dan sembunyikan avatar default
                        if (previewLogo) {
                            previewLogo.src = e.target.result;
                            previewLogo.classList.remove('hidden');
                            if (defaultLogo) defaultLogo.classList.add('hidden');
                        } else {
                            // Jika preview belum ada, buat element baru
                            const newPreview = document.createElement('img');
                            newPreview.src = e.target.result;
                            newPreview.alt = "Logo Preview";
                            newPreview.id = "preview_logo";
                            newPreview.className = "h-full w-full object-contain";

                            const previewContainer = document.getElementById('logo_preview');
                            if (defaultLogo) previewContainer.removeChild(defaultLogo);
                            previewContainer.appendChild(newPreview);
                        }
                    }

                    reader.readAsDataURL(file);
                }
            });

            // Fungsi untuk menampilkan preview QR Code
            const qrInput = document.getElementById('qr_code');
            const previewQr = document.getElementById('preview_qr');
            const defaultQr = document.getElementById('default_qr');
            const selectedQrName = document.getElementById('selected_qr_name');

            qrInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    // Cek apakah file adalah gambar
                    if (!file.type.match('image.*')) {
                        alert('File harus berupa gambar (JPG, PNG, GIF)');
                        return;
                    }

                    // Cek ukuran file (max 2MB = 2 * 1024 * 1024 bytes)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran gambar terlalu besar. Maksimal 2MB.');
                        return;
                    }

                    // Tampilkan nama file
                    selectedQrName.textContent = file.name;

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Tampilkan preview dan sembunyikan avatar default
                        if (previewQr) {
                            previewQr.src = e.target.result;
                            previewQr.classList.remove('hidden');
                            if (defaultQr) defaultQr.classList.add('hidden');
                        } else {
                            // Jika preview belum ada, buat element baru
                            const newPreview = document.createElement('img');
                            newPreview.src = e.target.result;
                            newPreview.alt = "QR Code Preview";
                            newPreview.id = "preview_qr";
                            newPreview.className = "h-full w-full object-contain";

                            const previewContainer = document.getElementById('qr_preview');
                            if (defaultQr) previewContainer.removeChild(defaultQr);
                            previewContainer.appendChild(newPreview);
                        }
                    }

                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
