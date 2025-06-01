@extends('layouts.main')

@section('title', 'Pesanan Berhasil!')

@section('content')
    <div class="bg-gray-50 py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <!-- Header - Sukses Checkout -->
                        <div class="text-center mb-10">
                            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-4">
                                <svg class="h-12 w-12 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900 font-poppins">Terima Kasih Atas Pesanan Anda!</h2>
                            <p class="mt-2 text-gray-600">Pesanan anda telah berhasil dibuat dan sedang diproses.</p>
                        </div>

                        <!-- Detail Pesanan -->
                        <div class="border-t border-b border-gray-200 py-6 my-6">
                            <div class="flex justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Detail Pesanan</h3>
                                    <p class="text-sm text-gray-500">Nomor Pesanan: <span
                                            class="font-medium">{{ $order->order_number }}</span></p>
                                    <p class="text-sm text-gray-500">Tanggal: <span
                                            class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span></p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <p class="text-sm text-gray-500 mt-1">Status Pembayaran:
                                        <span
                                            class="font-medium {{ $order->payment_status === 'pending' ? 'text-yellow-600' : 'text-green-600' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <!-- Items yang dipesan -->
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Layanan yang Dipesan</h4>
                                <div class="space-y-4">
                                    @foreach ($order->items as $item)
                                        <div class="flex">
                                            <div class="ml-3 flex-1">
                                                <div class="flex justify-between">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $item->name }}</p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            Teknisi:
                                                            {{ $item->tukangProfile ? $item->tukangProfile->user->name : 'Belum ditugaskan' }}
                                                        </p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-sm font-medium text-gray-900">Rp
                                                            {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                                        <p class="mt-1 text-sm text-gray-500">{{ $item->quantity }} x Rp
                                                            {{ number_format($item->price, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pelanggan & Lokasi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 mb-3">Informasi Pelanggan</h3>
                                <p class="text-sm text-gray-600">{{ $order->customer_name }}</p>
                                <p class="text-sm text-gray-600">{{ $order->customer_phone }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 mb-3">Lokasi Pengerjaan</h3>
                                <p class="text-sm text-gray-600">{{ $order->customer_address }}</p>
                                @if ($order->notes)
                                    <p class="text-sm text-gray-500 mt-2">Catatan: {{ $order->notes }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Metode Pembayaran & Total -->
                        <div class="border-t border-gray-200 pt-6 my-6">
                            <div class="flex justify-between mb-2">
                                <p class="text-sm text-gray-600">Metode Pembayaran</p>
                                <p class="text-sm font-medium text-gray-900">{{ $order->paymentOption->name }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-base font-medium text-gray-900">Total</p>
                                <p class="text-base font-medium text-gray-900">Rp
                                    {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4 my-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">
                                        Petunjuk Selanjutnya
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Instruksi pembayaran telah dikirim ke email Anda.</li>
                                            <li>Segera lakukan pembayaran agar pesanan dapat diproses.</li>
                                            <li>Anda dapat melihat status pesanan di halaman "Pesanan Saya".</li>
                                            <li>Teknisi akan menghubungi Anda untuk konfirmasi jadwal pengerjaan.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-8 flex justify-between">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                Kembali ke Beranda
                            </a>

                            <a href="{{ route('orders.show', $order->id) }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#28244D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60]">
                                Lihat Detail Pesanan
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full z-[60] relative">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Berikan Ulasan
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Bagaimana pengalaman Anda dengan layanan kami? Ulasan Anda sangat berarti untuk kami.
                                </p>
                                <div class="mt-4">
                                    <textarea id="reviewContent" rows="4"
                                        class="shadow-sm focus:ring-[#332E60] focus:border-[#332E60] block w-full sm:text-sm border-gray-300 rounded-md p-3"
                                        placeholder="Tulis ulasan Anda di sini..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="submitReview"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#332E60] text-base font-medium text-white hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60] sm:ml-3 sm:w-auto sm:text-sm">
                        Kirim Ulasan
                    </button>
                    <button type="button" id="skipReview"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Lewati
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Clear cart data from localStorage after successful checkout
        document.addEventListener('DOMContentLoaded', function() {
            // Clear the cart in localStorage
            localStorage.setItem('cart', '[]');

            // Update cart count in UI
            const cartCountElements = document.querySelectorAll('[id^="cartCount"]');
            cartCountElements.forEach(element => {
                element.textContent = '0';
            });

            // Dispatch event to notify other components
            document.dispatchEvent(new CustomEvent('cartUpdated', {
                detail: {
                    cart: []
                }
            }));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show review modal after page loads
            setTimeout(() => {
                document.getElementById('reviewModal').style.display = 'block';
            }, 1000);

            // Handle submit review
            document.getElementById('submitReview').addEventListener('click', function() {
                const content = document.getElementById('reviewContent').value;
                if (content.trim().length < 5) {
                    alert('Mohon isi ulasan minimal 5 karakter');
                    return;
                }

                // Send AJAX request
                fetch('{{ route('reviews.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order_id: '{{ $order->id }}',
                            content: content
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Terima kasih atas ulasan Anda!',
                                icon: 'success',
                                confirmButtonColor: '#332E60'
                            });
                            // Close modal
                            document.getElementById('reviewModal').style.display = 'none';
                        } else {
                            alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
            });

            // Handle skip review
            document.getElementById('skipReview').addEventListener('click', function() {
                document.getElementById('reviewModal').style.display = 'none';
            });

            // Close modal when clicking outside (on the overlay)
            document.getElementById('reviewModal').addEventListener('click', function(e) {
                // Close only if clicking the overlay background, not the modal content
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        });
    </script>
@endsection
