@extends('layouts.main')

@section('title', $jasa->nama)

@section('content')
    <div class="bg-gray-50 py-12 md:py-32">
        <div class="container mx-auto px-6 md:px-12">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#332E60]">Beranda</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-[#332E60] font-medium">{{ $jasa->nama }}</span>
                    </li>
                </ol>
            </nav>

            <!-- Jasa Header -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-10">
                <div class="md:flex">
                    <div class="md:flex-shrink-0 md:w-1/3">
                        <div class="h-64 md:h-full bg-gray-200">
                            @if ($jasa->gambar)
                                <img src="{{ Storage::url($jasa->gambar) }}" alt="{{ $jasa->nama }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full bg-gray-200">
                                    <svg class="h-24 w-24 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="p-8 md:w-2/3">
                        <h1 class="text-3xl font-bold text-[#332E60] mb-4 font-poppins">{{ $jasa->nama }}</h1>

                        <div class="prose max-w-none text-gray-600 mt-4">
                            <p>{!! nl2br(e($jasa->deskripsi)) !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub Jasa Section -->
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-[#332E60] mb-6 font-poppins">Pilihan <span
                        class="text-[#F4C542]">Layanan</span> {{ $jasa->nama }}</h2>
                <p class="text-gray-600 max-w-3xl mb-8">Pilih layanan spesifik yang sesuai dengan kebutuhan Anda.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($jasa->subJasa as $subJasa)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-105">
                            <div class="h-48 bg-gray-200 relative">
                                @if ($subJasa->gambar)
                                    <img src="{{ Storage::url($subJasa->gambar) }}" alt="{{ $subJasa->nama }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/login-bg.png') }}" alt="{{ $subJasa->nama }}"
                                        class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-[#332E60] font-poppins mb-2">{{ $subJasa->nama }}
                                </h3>
                                <div class="mb-3">
                                    <span
                                        class="bg-blue-50 text-blue-700 py-1 px-2 rounded-lg text-sm font-medium font-mono inline-block">
                                        Rp
                                        {{ number_format($subJasa->harga, 0, ',', '.') }}{{ $subJasa->satuan ? '/' . $subJasa->satuan : '' }}
                                    </span>
                                </div>
                                <p class="text-gray-600 mb-4">{{ Str::limit($subJasa->deskripsi, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <button onclick="showDetail({{ json_encode($subJasa) }})"
                                        class="text-[#F4C542] font-semibold inline-flex items-center hover:text-[#e0b53d] transition-all">
                                        Lihat Detail
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    @auth
                                        <button
                                            onclick="addToCart('{{ $subJasa->id }}', '{{ $subJasa->nama }}', '{{ $subJasa->harga }}', '{{ Storage::url($subJasa->gambar ?? '') }}', '{{ $subJasa->satuan }}')"
                                            class="bg-[#332E60] hover:bg-[#28244D] text-white px-3 py-2 rounded-lg transition-all inline-flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Keranjang
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="bg-[#332E60] hover:bg-[#28244D] text-white px-3 py-2 rounded-lg transition-all inline-flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Login untuk Beli
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada sub jasa tersedia</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Silakan kembali nanti, kami sedang menambahkan layanan baru untuk kategori ini.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <!-- Close button -->
                    <div class="absolute top-0 right-0 pt-4 pr-4">
                        <button type="button" onclick="closeModal()"
                            class="bg-white rounded-md text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal content -->
                    <div id="modalContent" class="sm:flex sm:items-start">
                        <!-- Content will be dynamically loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
        let currentSubJasa = null;

        function showDetail(subJasa) {
            currentSubJasa = subJasa;

            // Show modal
            document.getElementById('detailModal').classList.remove('hidden');

            // Load content
            const modalContent = document.getElementById('modalContent');

            // Determine image URL
            let imageUrl;
            if (subJasa.gambar) {
                imageUrl = `/storage/${subJasa.gambar}`;
            } else {
                imageUrl = '/images/login-bg.png';
            }

            modalContent.innerHTML = `
                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                    <!-- Image -->
                    <div class="mb-6">
                        <img src="${imageUrl}" alt="${subJasa.nama}" 
                             class="w-full h-64 object-cover rounded-lg shadow-md">
                    </div>
                    
                    <!-- Title and Price -->
                    <div class="mb-4">
                        <h3 class="text-2xl leading-6 font-bold text-[#332E60] font-poppins mb-2" id="modal-title">
                            ${subJasa.nama}
                        </h3>
                        <div class="mb-4">
                            <span class="bg-blue-50 text-blue-700 py-2 px-4 rounded-lg text-lg font-bold font-mono inline-block">
                                Rp ${new Intl.NumberFormat('id-ID').format(subJasa.harga)}${subJasa.satuan ? '/' + subJasa.satuan : ''}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-2 font-poppins">Deskripsi</h4>
                        <div class="text-gray-600 leading-relaxed bg-gray-50 p-4 rounded-lg">
                            ${subJasa.deskripsi ? subJasa.deskripsi.replace(/\n/g, '<br>') : 'Tidak ada deskripsi tersedia untuk layanan ini.'}
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                        <button onclick="closeModal()" 
                                class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60] transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tutup
                        </button>
                        
                        ${isAuthenticated ? 
                            `<button onclick="addToCartFromModal()" 
                                             class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-[#332E60] text-white font-semibold rounded-lg hover:bg-[#28244D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60] transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>` :
                            `<a href="/login" 
                                       class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-[#F4C542] text-[#332E60] font-semibold rounded-lg hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542] transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Login untuk Beli
                                    </a>`
                        }
                    </div>
                </div>
            `;
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
            currentSubJasa = null;
        }

        // Close modal when clicking Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        function addToCart(id, name, price, image, satuan) {
            if (!isAuthenticated) {
                window.location.href = '/login';
                return;
            }

            if (window.cartManager) {
                // Fix image URL
                let imageUrl = image;
                if (!image || image === '' || image === 'null' || image.includes('null')) {
                    imageUrl = '/images/login-bg.png';
                }

                window.cartManager.addToCart(id, name, price, imageUrl, satuan, 1);
            }
        }

        function addToCartFromModal() {
            if (!isAuthenticated) {
                window.location.href = '/login';
                return;
            }

            if (currentSubJasa && window.cartManager) {
                // Determine proper image URL
                let imageUrl;
                if (currentSubJasa.gambar) {
                    imageUrl = `/storage/${currentSubJasa.gambar}`;
                } else {
                    imageUrl = '/images/login-bg.png';
                }

                window.cartManager.addToCart(
                    currentSubJasa.id,
                    currentSubJasa.nama,
                    currentSubJasa.harga,
                    imageUrl,
                    currentSubJasa.satuan,
                    1
                );

                closeModal();
            }
        }
    </script>
@endsection
