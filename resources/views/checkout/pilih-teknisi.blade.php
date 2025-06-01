@extends('layouts.main')

@section('title', 'Pilih Teknisi')

@section('content')
    <div class="bg-gray-50 py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Progress Steps Container -->
                <div class="border-b border-gray-200 pb-8 mb-8">
                    <div class="relative">
                        <!-- Background Track -->
                        <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200"></div>

                        <!-- Progress Bar - Width berubah berdasarkan langkah -->
                        <div class="absolute top-5 left-0 h-1 bg-[#332E60] transition-all duration-500 ease-in-out"
                            style="width: 33.33%"></div>

                        <!-- Step Indicators -->
                        <div class="relative flex justify-between">
                            <!-- Step 1: Review Keranjang -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full bg-[#332E60] text-white">
                                    <!-- Checkmark Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs text-gray-500">Review Keranjang</span>
                            </div>

                            <!-- Step 2: Pilih Teknisi -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full bg-[#332E60] text-white">
                                    <span>2</span>
                                </div>
                                <span class="mt-2 text-xs font-medium text-gray-900">Pilih Teknisi</span>
                            </div>

                            <!-- Step 3: Informasi Pengiriman -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full bg-white border-2 border-gray-300 text-gray-500">
                                    <span>3</span>
                                </div>
                                <span class="mt-2 text-xs text-gray-500">Informasi Pengiriman</span>
                            </div>

                            <!-- Step 4: Pembayaran -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 rounded-full bg-white border-2 border-gray-300 text-gray-500">
                                    <span>4</span>
                                </div>
                                <span class="mt-2 text-xs text-gray-500">Pembayaran</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-2xl font-bold text-gray-900 font-poppins mb-6">Pilih Teknisi untuk Layanan Anda</h2>

                        <form action="{{ route('checkout.save-technicians') }}" method="POST">
                            @csrf
                            <div class="space-y-8">
                                @foreach ($cart as $index => $item)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-4">
                                            <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-md overflow-hidden">
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                    class="h-full w-full object-cover"
                                                    onerror="this.onerror=null; this.src='/images/login-bg.png';">
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="text-lg font-medium text-gray-900">{{ $item['name'] }}</h3>
                                                <p class="text-sm text-gray-500">
                                                    Rp
                                                    {{ number_format($item['price'], 0, ',', '.') }}{{ $item['satuan'] ? '/' . $item['satuan'] : '' }}
                                                    × {{ $item['quantity'] }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Menampilkan teknisi yang tersedia untuk layanan ini -->
                                        @if (isset($availableTechnicians[$item['id']]) && count($availableTechnicians[$item['id']]) > 0)
                                            <h4 class="text-sm font-medium text-gray-900 mb-3">Pilih teknisi untuk layanan
                                                ini:</h4>

                                            <input type="hidden" name="item_indices[]" value="{{ $index }}">

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                @foreach ($availableTechnicians[$item['id']] as $tukang)
                                                    <div class="border rounded-lg p-4 hover:border-[#332E60] hover:bg-blue-50 cursor-pointer transition-all duration-200 
                                                        {{ session('selected_technicians.' . $index) == $tukang->id ? 'border-[#332E60] bg-blue-50' : 'border-gray-200' }}"
                                                        onclick="selectTechnician(this, '{{ $index }}', '{{ $tukang->id }}')">
                                                        <div class="flex items-center">
                                                            <div
                                                                class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-full overflow-hidden">
                                                                <img src="{{ $tukang->profile_photo ? Storage::url($tukang->profile_photo) : '/images/default-avatar.png' }}"
                                                                    alt="{{ $tukang->name }}"
                                                                    class="h-full w-full object-cover"
                                                                    onerror="this.onerror=null; this.src='/images/default-avatar.png';">
                                                            </div>
                                                            <div class="ml-4">
                                                                <h3 class="text-sm font-medium text-gray-900">
                                                                    {{ $tukang->name }}</h3>
                                                                <p class="text-xs text-gray-500">
                                                                    {{ $tukang->location ? $tukang->location->name : 'Lokasi tidak tersedia' }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="mt-3 flex items-center justify-between">
                                                            <button type="button"
                                                                class="text-xs text-[#332E60] hover:underline focus:outline-none"
                                                                onclick="showTukangDetail('{{ $tukang->id }}', event)">
                                                                Lihat Detail
                                                            </button>

                                                            <div class="relative flex items-center">
                                                                <input type="radio"
                                                                    name="technician[{{ $index }}]"
                                                                    value="{{ $tukang->id }}"
                                                                    id="tech_{{ $index }}_{{ $tukang->id }}"
                                                                    class="h-4 w-4 text-[#332E60] focus:ring-[#332E60] border-gray-300"
                                                                    {{ session('selected_technicians.' . $index) == $tukang->id ? 'checked' : '' }}
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-yellow-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-yellow-800">
                                                            Tidak ada teknisi yang tersedia
                                                        </h3>
                                                        <div class="mt-2 text-sm text-yellow-700">
                                                            <p>
                                                                Saat ini tidak ada teknisi yang memiliki keahlian untuk
                                                                layanan ini. Silakan hubungi kami untuk informasi lebih
                                                                lanjut.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-8 flex justify-between">
                                <a href="{{ route('checkout.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Kembali
                                </a>

                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#28244D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                    Lanjutkan
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Teknisi -->
    <div id="tukangDetailModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div id="modalContent" class="sm:flex sm:items-start">
                        <!-- Content will be loaded here -->
                        <div class="text-center w-full py-10">
                            <svg class="mx-auto h-10 w-10 text-gray-400 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Memuat data teknisi...</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Untuk menandai pilihan teknisi
        function selectTechnician(element, itemIndex, tukangId) {
            // Update tampilan elemen yang dipilih
            const containers = document.querySelectorAll(`[name="technician[${itemIndex}]"]`).forEach(radio => {
                const container = radio.closest('div.border');
                container.classList.remove('border-[#332E60]', 'bg-blue-50');
                container.classList.add('border-gray-200');
            });

            element.classList.remove('border-gray-200');
            element.classList.add('border-[#332E60]', 'bg-blue-50');

            // Set radio button yang sesuai
            document.getElementById(`tech_${itemIndex}_${tukangId}`).checked = true;
        }

        // Untuk menampilkan detail teknisi dalam modal
        function showTukangDetail(tukangId, event) {
            // Mencegah event click dari memilih teknisi
            if (event) event.stopPropagation();

            const modal = document.getElementById('tukangDetailModal');
            const modalContent = document.getElementById('modalContent');

            // Tampilkan modal
            modal.classList.remove('hidden');

            // Ambil data teknisi dari API
            fetch(`/api/tukang-profile/${tukangId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal memuat data teknisi');
                    }
                    return response.json();
                })
                .then(data => {
                    // Render data teknisi
                    modalContent.innerHTML = `
                    <div class="w-full">
                        <div class="text-center mb-6">
                            <div class="mx-auto h-24 w-24 rounded-full overflow-hidden bg-gray-100">
                                <img src="${data.profile_photo ? '/storage/' + data.profile_photo : '/images/default-avatar.png'}" 
                                     alt="${data.name}" class="h-full w-full object-cover">
                            </div>
                            <h3 class="mt-3 text-lg font-medium text-gray-900">${data.name}</h3>
                            <p class="text-sm text-gray-500">${data.location ? data.location.name : 'Lokasi tidak tersedia'}</p>
                        </div>
                        
                        <div class="border-t border-gray-200 py-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Tentang Teknisi</h4>
                            <p class="text-sm text-gray-600">${data.bio || 'Tidak ada informasi bio.'}</p>
                        </div>
                        
                        <div class="border-t border-gray-200 py-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Keahlian</h4>
                            <div class="flex flex-wrap gap-2">
                                ${data.skills && data.skills.length > 0 
                                    ? data.skills.map(skill => 
                                        `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        ${skill.nama}
                                                    </span>`
                                    ).join('') 
                                    : '<p class="text-sm text-gray-500">Tidak ada keahlian yang tercatat.</p>'
                                }
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 py-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Kontak</h4>
                            <p class="text-sm text-gray-600">${data.phone_number || 'Tidak tersedia'}</p>
                            <p class="text-sm text-gray-600">${data.email || 'Tidak tersedia'}</p>
                        </div>
                    </div>
                `;
                })
                .catch(error => {
                    modalContent.innerHTML = `
                    <div class="w-full text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-gray-500">Gagal memuat data teknisi: ${error.message}</p>
                    </div>
                `;
                });
        }

        // Untuk menutup modal
        function closeModal() {
            const modal = document.getElementById('tukangDetailModal');
            modal.classList.add('hidden');
        }

        // Tutup modal jika user klik di luar modal atau tekan Escape
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('tukangDetailModal');
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
@endsection
