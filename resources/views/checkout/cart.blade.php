@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="bg-gray-50 py-12 md:py-32">
        <div class="container mx-auto px-6 md:px-12 max-w-7xl">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-extrabold text-gray-900 font-poppins mb-6">Keranjang Belanja</h1>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <div id="cartContent">
                            <!-- Cart items will be rendered here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil data cart dari server terlebih dahulu
            fetch('{{ route('cart.get') }}')
                .then(response => response.json())
                .then(data => {
                    const serverCart = data.cart || [];
                    const localCart = JSON.parse(localStorage.getItem('cart') || '[]');

                    // Jika server cart kosong tapi local cart ada isinya, sync ke server
                    if (serverCart.length === 0 && localCart.length > 0) {
                        syncCartWithServer(localCart);
                    }
                    // Jika server cart ada isinya tapi berbeda dengan local cart, gunakan server cart
                    else if (serverCart.length > 0) {
                        localStorage.setItem('cart', JSON.stringify(serverCart));
                    }

                    renderCart();
                })
                .catch(error => {
                    console.error('Error fetching cart data:', error);
                    renderCart(); // Render dari localStorage sebagai fallback
                });

            // Listen for cart updates
            document.addEventListener('cartUpdated', function() {
                renderCart();
            });
        });

        function renderCart() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const cartContent = document.getElementById('cartContent');

            if (cart.length === 0) {
                // Empty cart view
                cartContent.innerHTML = `
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Keranjang Kosong</h3>
                    <p class="mt-1 text-sm text-gray-500">Keranjang belanja Anda kosong. Silakan tambahkan layanan terlebih dahulu.</p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#28244D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                            Lihat Layanan
                        </a>
                    </div>
                </div>
            `;
                return;
            }

            // Calculate total
            const total = cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);

            // Render cart items
            let cartHtml = `
            <div class="flow-root">
                <ul class="-my-6 divide-y divide-gray-200">
        `;

            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                cartHtml += `
                <li class="py-6 flex">
                    <div class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-md overflow-hidden">
                        <img src="${item.image}" alt="${item.name}" 
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.src='/images/login-bg.png';">
                    </div>
                    <div class="ml-4 flex-1 flex flex-col">
                        <div>
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <h3>${item.name}</h3>
                                <p class="ml-4">Rp ${subtotal.toLocaleString('id-ID')}</p>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Rp ${parseInt(item.price).toLocaleString('id-ID')}
                                ${item.satuan ? `/${item.satuan}` : ''}
                            </p>
                        </div>
                        <div class="flex-1 flex items-end justify-between text-sm">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <button onclick="decrementQuantity(${index})" class="px-3 py-1 text-gray-500 hover:text-gray-700 focus:outline-none">
                                    -
                                </button>
                                <span class="px-3 py-1 text-gray-700">${item.quantity}</span>
                                <button onclick="incrementQuantity(${index})" class="px-3 py-1 text-gray-500 hover:text-gray-700 focus:outline-none">
                                    +
                                </button>
                            </div>
                            <div class="flex">
                                <button onclick="removeFromCart(${index})" class="font-medium text-red-600 hover:text-red-500">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            `;
            });

            cartHtml += `
                </ul>
            </div>
            
            <div class="mt-8 border-t border-gray-200 pt-6">
                <div class="flex justify-between text-base font-medium text-gray-900 mb-4">
                    <p>Subtotal</p>
                    <p>Rp ${total.toLocaleString('id-ID')}</p>
                </div>
                <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('home') }}" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Lanjutkan Belanja
                    </a>
                    <a href="{{ route('checkout.index') }}" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-[#332E60] hover:bg-[#28244D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                        Lanjutkan ke Checkout
                    </a>
                </div>
            </div>
        `;

            cartContent.innerHTML = cartHtml;
        }

        function incrementQuantity(index) {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (cart[index]) {
                cart[index].quantity += 1;
                updateCart(cart, index);
            }
        }

        function decrementQuantity(index) {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (cart[index] && cart[index].quantity > 1) {
                cart[index].quantity -= 1;
                updateCart(cart, index);
            }
        }

        function removeFromCart(index) {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (cart[index]) {
                // Use AJAX to update server-side cart
                fetch('{{ route('cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            index: index
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update local cart
                            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
                            cart.splice(index, 1);
                            localStorage.setItem('cart', JSON.stringify(cart));

                            // Update UI
                            renderCart();
                            updateCartUI();

                            // Show notification
                            showNotification('Item berhasil dihapus dari keranjang');
                        }
                    })
                    .catch(error => {
                        console.error('Error removing item from cart:', error);
                    });
            }
        }

        function updateCart(cart, index) {
            // Use AJAX to update server-side cart
            fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        index: index,
                        quantity: cart[index].quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update local cart
                        localStorage.setItem('cart', JSON.stringify(cart));

                        // Update UI
                        renderCart();
                        updateCartUI();
                    }
                })
                .catch(error => {
                    console.error('Error updating cart:', error);
                });
        }

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className =
                'fixed bottom-4 right-4 bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded z-50';
            notification.innerHTML = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
@endsection
