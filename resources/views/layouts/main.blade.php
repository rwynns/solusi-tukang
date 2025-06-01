<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Solusi Tukang' }}</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
</head>

<body>
    @include('partials.navbar')
    <main>
        @yield('content')
    </main>
    <script>
        function Openbar() {
            document.querySelector('.sidebar').classList.toggle('left-[-300px]')
        }
    </script>
    <!-- Flash Message Handler untuk SweetAlert -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tampilkan Sweet Alert jika ada pesan sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            @endif

            // Tampilkan Sweet Alert jika ada pesan error
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

    <!-- Cart and checkout functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize cart
            let cart = JSON.parse(localStorage.getItem('cart') || '[]');

            // Setup event listeners
            const cartButton = document.getElementById('cartButton');
            const mobileCartButton = document.getElementById('mobileCartButton');
            const proceedToCheckout = document.getElementById('proceedToCheckout');
            const confirmOrder = document.getElementById('confirmOrder');

            if (cartButton) cartButton.addEventListener('click', openCartModal);
            if (mobileCartButton) mobileCartButton.addEventListener('click', openCartModal);
            if (proceedToCheckout) proceedToCheckout.addEventListener('click', proceedToCheckout);
            if (confirmOrder) confirmOrder.addEventListener('click', handleOrderConfirmation);

            // Initialize cart count
            updateCartCount();
        });

        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const count = cart.reduce((total, item) => total + item.quantity, 0);

            // Get all cart count elements to ensure we update them everywhere
            const cartCountElements = document.querySelectorAll('[id^="cartCount"]');
            cartCountElements.forEach(element => {
                element.textContent = count;
            });

            // Also update specific elements by ID for backwards compatibility
            const desktopCount = document.getElementById('cartCount');
            const mobileCount = document.getElementById('mobileCartCount');

            if (desktopCount) desktopCount.textContent = count;
            if (mobileCount) mobileCount.textContent = count;
        }

        function openCartModal() {
            @guest
            window.location.href = '{{ route('login') }}';
            return;
        @endguest

        const cartModal = document.getElementById('cartModal');
        if (!cartModal) return;

        // Show modal
        cartModal.classList.remove('hidden');

        // Add backdrop click handler
        const backdrop = cartModal.querySelector('.fixed.inset-0.transition-opacity');
        if (backdrop) {
            backdrop.addEventListener('click', function(e) {
                if (e.target === backdrop || e.target === backdrop.querySelector('div')) {
                    closeCartModal();
                }
            });
        }

        // Load cart items
        renderCartItems();
        }

        function closeCartModal() {
            const cartModal = document.getElementById('cartModal');
            if (cartModal) cartModal.classList.add('hidden');
        }

        function openCheckoutModal() {
            @guest
            window.location.href = '{{ route('login') }}';
            return;
        @endguest

        closeCartModal();

        const checkoutModal = document.getElementById('checkoutModal');
        if (!checkoutModal) return;

        // Show modal
        checkoutModal.classList.remove('hidden');

        // Render checkout items
        renderCheckoutItems();
        }

        function closeCheckoutModal() {
            const checkoutModal = document.getElementById('checkoutModal');
            if (checkoutModal) checkoutModal.classList.add('hidden');
            openCartModal();
        }

        function renderCartItems() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const cartItemsContainer = document.getElementById('cartItems');
            const cartSummary = document.getElementById('cartSummary');
            const cartSubtotal = document.getElementById('cartSubtotal');

            if (!cartItemsContainer) return;

            // Clear container
            cartItemsContainer.innerHTML = '';

            if (cart.length === 0) {
                // Show empty cart message
                cartItemsContainer.innerHTML = `
                    <div class="py-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="mt-2">Keranjang belanja Anda kosong</p>
                        <p class="mt-1 text-sm">Tambahkan layanan yang Anda butuhkan</p>
                    </div>
                `;

                // Hide summary
                if (cartSummary) cartSummary.classList.add('hidden');

                return;
            }

            // Calculate subtotal
            const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);

            // Render each item
            cart.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.className = 'py-4 flex';
                itemElement.innerHTML = `
                    <div class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-md overflow-hidden">
                        <img src="${item.image}" alt="${item.name}" 
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.src='/images/login-bg.png';">
                    </div>
                    <div class="ml-4 flex-1 flex flex-col">
                        <div>
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <h3>${item.name}</h3>
                                <div class="ml-4 text-right">
                                    <p>Rp ${Number(item.price).toLocaleString('id-ID')}</p>
                                    ${item.satuan ? `<p class="text-xs text-gray-500">per ${item.satuan}</p>` : ''}
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 flex items-end justify-between text-sm">
                            <div class="flex items-center">
                                <button onclick="decrementItem(${index})" class="text-gray-500 hover:text-gray-700 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </button>
                                <span class="mx-2 text-gray-500">Jumlah: ${item.quantity}</span>
                                <button onclick="incrementItem(${index})" class="text-gray-500 hover:text-gray-700 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex">
                                <button type="button" onclick="removeItem(${index})" class="font-medium text-red-600 hover:text-red-500">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                cartItemsContainer.appendChild(itemElement);
            });

            // Show summary
            if (cartSummary) {
                cartSummary.classList.remove('hidden');
                if (cartSubtotal) cartSubtotal.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            }
        }

        function renderCheckoutItems() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const checkoutItemsContainer = document.getElementById('checkoutItems');
            const checkoutTotal = document.getElementById('checkoutTotal');

            if (!checkoutItemsContainer) return;

            // Clear container
            checkoutItemsContainer.innerHTML = '';

            // Calculate total
            const total = cart.reduce((total, item) => total + (item.price * item.quantity), 0);

            // Render each item
            cart.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'py-3 flex justify-between';
                itemElement.innerHTML = `
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-900">${item.name}</span>
                        <span class="ml-2 text-xs text-gray-500">x${item.quantity}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900">
                            Rp ${(item.price * item.quantity).toLocaleString('id-ID')}
                        </span>
                        ${item.satuan ? `<span class="block text-xs text-gray-500">@${item.price.toLocaleString('id-ID')}/${item.satuan}</span>` : ''}
                    </div>
                `;
                checkoutItemsContainer.appendChild(itemElement);
            });

            // Update total
            if (checkoutTotal) checkoutTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        function incrementItem(index) {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (cart[index]) {
                cart[index].quantity += 1;
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCartItems();
                updateCartCount();
                document.dispatchEvent(new CustomEvent('cartUpdated', {
                    detail: {
                        cart: cart
                    }
                }));
            }
        }

        function decrementItem(index) {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (cart[index]) {
                if (cart[index].quantity > 1) {
                    cart[index].quantity -= 1;
                } else {
                    cart.splice(index, 1);
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCartItems();
                updateCartCount();
                document.dispatchEvent(new CustomEvent('cartUpdated', {
                    detail: {
                        cart: cart
                    }
                }));
            }
        }

        function removeItem(index) {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (cart[index]) {
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));

                // Force immediate UI update in all places
                renderCartItems();
                updateCartCount();

                // Add a custom event to notify other parts of the application
                document.dispatchEvent(new CustomEvent('cartUpdated', {
                    detail: {
                        cart: cart
                    }
                }));
            }
        }

        function handleOrderConfirmation() {
            // In a real implementation, this would submit the order to your backend
            // For now, just show a success message and clear the cart

            const checkoutForm = document.getElementById('checkoutForm');
            if (!checkoutForm) return;

            // Simple validation
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;

            if (!name || !phone || !address) {
                alert('Mohon lengkapi semua informasi yang diperlukan');
                return;
            }

            // Show success message
            alert('Pesanan berhasil dibuat! Kami akan segera menghubungi Anda.');

            // Clear cart
            localStorage.setItem('cart', '[]');
            updateCartCount();

            // Close modal
            closeCheckoutModal();
        }

        function proceedToCheckout() {
            @guest
            window.location.href = '{{ route('login') }}';
            return;
        @endguest

        // Redirect to the first checkout step instead of opening a modal
        window.location.href = '{{ route('checkout.index') }}';
        }
    </script>

    <!-- Cart Modal -->
    <div id="cartModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full relative z-10">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 font-poppins" id="modal-title">
                                Keranjang Belanja
                            </h3>

                            <div class="mt-4 divide-y divide-gray-200" id="cartItems">
                                <!-- Cart items will be inserted here by JavaScript -->
                                <div class="py-8 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="mt-2">Keranjang belanja Anda kosong</p>
                                    <p class="mt-1 text-sm">Tambahkan layanan yang Anda butuhkan</p>
                                </div>
                            </div>

                            <!-- Cart Summary -->
                            <div class="mt-6 pt-4 border-t border-gray-200 hidden" id="cartSummary">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>Subtotal</p>
                                    <p id="cartSubtotal">Rp 0</p>
                                </div>
                                <p class="mt-0.5 text-sm text-gray-500">Belum termasuk biaya tambahan lainnya.</p>

                                <!-- Checkout Button -->
                                <div class="mt-6">
                                    <a href="{{ route('cart.index') }}"
                                        class="w-full flex justify-center items-center px-6 py-3 bg-[#F4C542] hover:bg-[#e0b53d] text-[#332E60] font-poppins font-semibold rounded-xl">
                                        Lanjutkan ke Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeCartModal()"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 font-poppins" id="modal-title">
                                Checkout
                            </h3>

                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-900">Ringkasan Pesanan</h4>
                                <div class="mt-2 divide-y divide-gray-200" id="checkoutItems">
                                    <!-- Checkout items will be inserted here by JavaScript -->
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <p>Total</p>
                                        <p id="checkoutTotal">Rp 0</p>
                                    </div>
                                </div>
                            </div>

                            <form class="mt-6 space-y-4" id="checkoutForm">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama
                                        Lengkap</label>
                                    <input type="text" name="name" id="name"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#F4C542] focus:border-[#F4C542]">
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor
                                        Telepon</label>
                                    <input type="text" name="phone" id="phone"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#F4C542] focus:border-[#F4C542]">
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <textarea name="address" id="address" rows="3"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#F4C542] focus:border-[#F4C542]"></textarea>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan
                                        (opsional)</label>
                                    <textarea name="notes" id="notes" rows="2"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#F4C542] focus:border-[#F4C542]"></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input id="payment-transfer" name="payment-method" type="radio" checked
                                                class="focus:ring-[#F4C542] h-4 w-4 text-[#F4C542] border-gray-300">
                                            <label for="payment-transfer"
                                                class="ml-3 block text-sm font-medium text-gray-700">
                                                Transfer Bank
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="payment-cod" name="payment-method" type="radio"
                                                class="focus:ring-[#F4C542] h-4 w-4 text-[#F4C542] border-gray-300">
                                            <label for="payment-cod"
                                                class="ml-3 block text-sm font-medium text-gray-700">
                                                Bayar di Tempat (COD)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmOrder"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#F4C542] text-base font-medium text-[#332E60] hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542] sm:ml-3 sm:w-auto sm:text-sm">
                        Konfirmasi Pesanan
                    </button>
                    <button type="button" onclick="closeCheckoutModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>

</html>
