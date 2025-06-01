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
                                    <a href="#" onclick="showDetail('{{ $subJasa->id }}')"
                                        class="text-[#F4C542] font-semibold inline-flex items-center hover:text-[#e0b53d] transition-all">
                                        Lihat Detail
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
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
@endsection

@section('scripts')
    <script>
        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

        function showDetail(id) {
            // Show modal
            document.getElementById('detailModal').classList.remove('hidden');

            // Load content (in a real implementation, this would be an AJAX call)
            const modalContent = document.getElementById('modalContent');

            // Find the sub jasa data
            fetch(`/api/sub-jasa/${id}`)
                .then(response => response.json())
                .then(data => {
                    let subJasa = data;
                    modalContent.innerHTML = `
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 font-poppins" id="modal-title">
                            ${subJasa.nama}
                        </h3>
                        <div class="mt-2">
                            <span class="bg-blue-50 text-blue-700 py-1 px-3 rounded-full text-sm font-medium font-mono inline-block">
                                Rp ${new Intl.NumberFormat('id-ID').format(subJasa.harga)}${subJasa.satuan ? '/'+subJasa.satuan : ''}
                            </span>
                        </div>
                        
                        <div class="mt-4">
                            ${subJasa.gambar ? 
                                `<img src="/storage/${subJasa.gambar}" alt="${subJasa.nama}" class="w-full h-48 object-cover rounded-md">` : 
                                `<img src="https://source.unsplash.com/800x600/?construction,${encodeURIComponent(subJasa.nama)}" 
                                                                                                                                                                                                                                                         alt="${subJasa.nama}" class="w-full h-48 object-cover rounded-md">`
                            }
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">
                                ${subJasa.deskripsi ? subJasa.deskripsi.replace(/\n/g, '<br>') : 'Tidak ada deskripsi'}
                            </p>
                        </div>
                        
                        <div class="mt-8 grid grid-cols-2 gap-4">
                            <button class="inline-flex justify-center items-center px-4 py-2 bg-[#332E60] text-white rounded-md hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                Hubungi
                            </button>
                            
                            ${isAuthenticated ? 
                            `<button onclick="addToCartFromModal()" class="inline-flex justify-center items-center px-4 py-2 bg-[#F4C542] text-[#332E60] font-semibold rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                                                                                                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                                                                                                            </svg>
                                                                                                                                                            Tambah ke Keranjang
                                                                                                                                                        </button>` :
                            `<a href="/login" class="inline-flex justify-center items-center px-4 py-2 bg-[#F4C542] text-[#332E60] font-semibold rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                                                                                                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                                                                                                            </svg>
                                                                                                                                                            Login untuk Beli
                                                                                                                                                        </a>`}
                        </div>
                    </div>
                `;
                })
                .catch(error => {
                    modalContent.innerHTML = `
                    <div class="text-center py-10">
                        <svg class="mx-auto h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-gray-500">Gagal memuat data. Silakan coba lagi.</p>
                    </div>
                `;
                });
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Close modal when clicking Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Cart functionality
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        let currentSubJasa = null;

        // Update cart count on page load
        updateCartCount();

        function addToCart(id, name, price, image, satuan) {
            if (!isAuthenticated) {
                window.location.href = '/login';
                return;
            }

            // Get latest cart data
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');

            // Check if item already exists in cart
            const existingItemIndex = cart.findIndex(item => item.id === id);

            // Fix image URL - ensure it has a valid value
            let imageUrl = image;
            if (!image || image === '' || image === 'null' || image.includes('null')) {
                imageUrl = '/images/login-bg.png';
            }

            if (existingItemIndex > -1) {
                // Increment quantity if item exists
                cart[existingItemIndex].quantity += 1;
            } else {
                // Add new item with fixed image URL and satuan
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    image: imageUrl,
                    quantity: 1,
                    satuan: satuan // Store the unit information
                });
            }

            // Save to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // TAMBAHKAN: Sync dengan server
            syncCartWithServer(cart);

            // Update cart count
            updateCartUI();

            // Show success notification
            showNotification(`${name} telah ditambahkan ke keranjang`);
        }

        // Fungsi baru untuk sinkronisasi dengan server
        function syncCartWithServer(cart) {
            fetch('{{ route('cart.sync') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cart: cart
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        console.error('Failed to sync cart with server');
                    }
                })
                .catch(error => {
                    console.error('Error syncing cart with server:', error);
                });
        }

        // Helper function to directly update UI without events
        function updateCartUI() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const count = cart.reduce((total, item) => total + item.quantity, 0);

            const cartCountEl = document.getElementById('cartCount');
            const mobileCartCountEl = document.getElementById('mobileCartCount');

            if (cartCountEl) cartCountEl.textContent = count;
            if (mobileCartCountEl) mobileCartCountEl.textContent = count;
        }

        function addToCartFromModal() {
            if (!isAuthenticated) {
                window.location.href = '/login';
                return;
            }

            if (currentSubJasa) {
                // Determine proper image URL
                let imageUrl;
                if (currentSubJasa.gambar && currentSubJasa.gambar !== 'null') {
                    imageUrl = `/storage/${currentSubJasa.gambar}`;
                } else {
                    imageUrl = '/images/login-bg.png';
                }

                addToCart(
                    currentSubJasa.id,
                    currentSubJasa.nama,
                    currentSubJasa.harga,
                    imageUrl,
                    currentSubJasa.satuan // Add satuan here
                );
                closeModal();
            }
        }

        function updateCartCount() {
            // Calculate total quantity
            const count = cart.reduce((total, item) => total + item.quantity, 0);

            // Update UI
            document.getElementById('cartCount').textContent = count;
            if (document.getElementById('mobileCartCount')) {
                document.getElementById('mobileCartCount').textContent = count;
            }
        }

        function showNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className =
                'fixed bottom-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md transition-opacity duration-500 ease-in-out z-50';
            notification.innerHTML = message;

            // Add to document
            document.body.appendChild(notification);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 500);
            }, 3000);
        }

        function showDetail(id) {
            // Show modal
            document.getElementById('detailModal').classList.remove('hidden');

            // Load content (in a real implementation, this would be an AJAX call)
            const modalContent = document.getElementById('modalContent');

            // Find the sub jasa data
            fetch(`/api/sub-jasa/${id}`)
                .then(response => response.json())
                .then(data => {
                    let subJasa = data;
                    modalContent.innerHTML = `
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 font-poppins" id="modal-title">
                            ${subJasa.nama}
                        </h3>
                        <div class="mt-2">
                            <span class="bg-blue-50 text-blue-700 py-1 px-3 rounded-full text-sm font-medium font-mono inline-block">
                                Rp ${new Intl.NumberFormat('id-ID').format(subJasa.harga)}${subJasa.satuan ? '/'+subJasa.satuan : ''}
                            </span>
                        </div>
                        
                        <div class="mt-4">
                            ${subJasa.gambar ? 
                                `<img src="/storage/${subJasa.gambar}" alt="${subJasa.nama}" class="w-full h-48 object-cover rounded-md">` : 
                                `<img src="https://source.unsplash.com/800x600/?construction,${encodeURIComponent(subJasa.nama)}" 
                                                                                                                                                                                                                                                         alt="${subJasa.nama}" class="w-full h-48 object-cover rounded-md">`
                            }
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">
                                ${subJasa.deskripsi ? subJasa.deskripsi.replace(/\n/g, '<br>') : 'Tidak ada deskripsi'}
                            </p>
                        </div>
                        
                        <div class="mt-8 grid grid-cols-2 gap-4">
                            <button class="inline-flex justify-center items-center px-4 py-2 bg-[#332E60] text-white rounded-md hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                Hubungi
                            </button>
                            
                            ${isAuthenticated ? 
                            `<button onclick="addToCartFromModal()" class="inline-flex justify-center items-center px-4 py-2 bg-[#F4C542] text-[#332E60] font-semibold rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                                                                                                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                                                                                                            </svg>
                                                                                                                                                            Tambah ke Keranjang
                                                                                                                                                        </button>` :
                            `<a href="/login" class="inline-flex justify-center items-center px-4 py-2 bg-[#F4C542] text-[#332E60] font-semibold rounded-md hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                                                                                                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                                                                                                            </svg>
                                                                                                                                                            Login untuk Beli
                                                                                                                                                        </a>`}
                        </div>
                    </div>
                `;
                })
                .catch(error => {
                    modalContent.innerHTML = `
                    <div class="text-center py-10">
                        <svg class="mx-auto h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-gray-500">Gagal memuat data. Silakan coba lagi.</p>
                    </div>
                `;
                });
        }
    </script>
@endsection
