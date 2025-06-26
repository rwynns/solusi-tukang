@extends('layouts.main')
@section('content')
    <section class="relative h-screen overflow-hidden">
        <div class="absolute inset-0 w-full h-full">
            <img src="{{ asset('images/hero-bg.png') }}" alt="Hero Background" class="w-full h-full object-cover grayscale-50">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>

        <div class="container mx-auto relative z-10 h-full flex flex-col justify-center items-center px-6 md:px-12 pt-16">
            <div class="max-w-6xl text-center">
                <h1 class="text-md md:text-4xl font-bold text-white mb-4 font-poppins leading-tight text-shadow-lg">Unlock
                    <span class="text-[#F4C542]">endless possibilities</span> with a diverse selection
                </h1>
                <h1 class="text-md md:text-4xl font-bold text-white mb-4 font-poppins leading-tight text-shadow-lg">of
                    skilled craftsmen at Solusi Tukang</h1>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mt-6">
                    <a href=""
                        class="bg-[#F4C542] hover:bg-[#e0b53d] text-[#332E60] px-8 py-3 rounded-xl transition-all font-poppins font-semibold text-[16px] uppercase inline-flex items-center justify-center">
                        Konsultasi Gratis
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang-kami" class="py-25 bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <div class="max-w-6xl mx-auto text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#332E60] mb-4 font-poppins">Tentang
                    <span class="text-[#F4C542]">Solusi</span> Tukang
                </h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Platform terpercaya yang menghubungkan pelanggan dengan jasa
                    profesional terbaik</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="order-2 lg:order-1">
                    <h3 class="text-2xl font-semibold text-[#332E60] mb-4 font-poppins">Menghubungkan Anda dengan Tenaga
                        Profesional Terbaik</h3>

                    <p class="text-gray-600 mb-6">Solusi Tukang hadir sebagai platform inovatif yang menghubungkan pelanggan
                        dengan para tukang terampil dan profesional dari berbagai bidang keahlian. Kami berkomitmen untuk
                        memudahkan Anda menemukan jasa perbaikan, renovasi, dan berbagai layanan lainnya untuk rumah atau
                        proyek Anda.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-3">
                                <div class="bg-[#F4C542] p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#332E60]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-[#332E60] font-poppins">Tukang Terverifikasi</h4>
                            </div>
                            <p class="text-gray-600">Semua tukang telah diverifikasi keahlian dan pengalamannya untuk
                                menjamin kualitas layanan.</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-3">
                                <div class="bg-[#F4C542] p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#332E60]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-[#332E60] font-poppins">Layanan Tepat Waktu</h4>
                            </div>
                            <p class="text-gray-600">Kami memastikan setiap proyek selesai sesuai dengan jadwal yang telah
                                disepakati.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-3">
                                <div class="bg-[#F4C542] p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#332E60]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-[#332E60] font-poppins">Pembayaran Aman</h4>
                            </div>
                            <p class="text-gray-600">Sistem pembayaran aman dan transparansi biaya sebelum memulai
                                pekerjaan.</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-3">
                                <div class="bg-[#F4C542] p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#332E60]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-[#332E60] font-poppins">Kualitas Terbaik</h4>
                            </div>
                            <p class="text-gray-600">Komitmen kami untuk memberikan layanan berkualitas terbaik untuk
                                kepuasan pelanggan.</p>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2 flex justify-center">
                    <div class="relative">
                        <div class="bg-[#332E60] w-72 h-72 rounded-full absolute -bottom-8 -right-8 z-0"></div>
                        <img src="{{ asset('images/hero-bg.png') }}" alt="Tentang Kami"
                            class="w-full max-w-md rounded-xl shadow-xl relative z-10">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" class="py-25 bg-gray-50">
        <div class="container mx-auto px-6 md:px-12">
            <div class="max-w-6xl mx-auto text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#332E60] mb-4 font-poppins">Layanan
                    <span class="text-[#F4C542]">Terbaik</span> Kami
                </h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Temukan berbagai layanan profesional dari para tukang terampil
                    kami untuk memenuhi kebutuhan proyek Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($jasaList as $jasa)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-105">
                        <div class="h-48 bg-gray-200 relative">
                            @if ($jasa->gambar)
                                <img src="{{ Storage::url($jasa->gambar) }}" alt="{{ $jasa->nama }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full bg-gray-200">
                                    <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-[#332E60] mb-2 font-poppins">{{ $jasa->nama }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($jasa->deskripsi, 200) }}</p>
                            <a href="{{ route('jasa.detail', $jasa) }}"
                                class="text-[#F4C542] font-semibold inline-flex items-center hover:text-[#e0b53d] transition-all">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada jasa yang tersedia</h3>
                        <p class="mt-1 text-sm text-gray-500">Jasa akan muncul setelah ditambahkan oleh admin.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Review Section -->
    <section id="ulasan" class="py-16 bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <div class="max-w-6xl mx-auto text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#332E60] mb-4 font-poppins">Ulasan
                    <span class="text-[#F4C542]">Pelanggan</span> Kami
                </h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Kami bangga dengan layanan yang kami berikan. Lihat apa yang
                    dikatakan pelanggan kami
                    tentang pengalaman mereka menggunakan jasa Solusi Tukang.</p>
            </div>

            <!-- Recent Reviews Display -->
            <div class="max-w-6xl mx-auto mt-16">
                <h3 class="text-2xl font-bold text-[#332E60] mb-6 font-poppins text-center">Ulasan Terbaru</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($latestReviews as $review)
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <div class="flex items-center mb-4">
                                <div
                                    class="h-12 w-12 rounded-full bg-[#332E60] flex items-center justify-center text-white font-semibold">
                                    {{ $review->user ? substr($review->user->name, 0, 2) : 'G' }}
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-[#332E60]">
                                        {{ $review->user ? $review->user->name : 'Tamu' }}
                                    </h4>
                                </div>
                            </div>
                            <p class="text-gray-600">{{ $review->content }}</p>
                            <div class="mt-4 text-sm text-gray-500">
                                @if (
                                    $review->order &&
                                        $review->order->items &&
                                        $review->order->items->count() > 0 &&
                                        $review->order->items->first()->subJasa &&
                                        $review->order->items->first()->subJasa->jasa)
                                    {{ $review->order->items->first()->subJasa->jasa->nama }}
                                @else
                                    Ulasan Umum
                                @endif
                                • {{ $review->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8">
                            <p class="text-gray-500">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-8">
                    <a href="#"
                        class="inline-flex items-center text-[#332E60] hover:text-[#F4C542] transition-colors font-semibold">
                        Lihat Semua Ulasan
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Display success/error messages if they exist in the session
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                });
            @endif
        });
    </script>
@endsection
