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

    <section class="py-16 bg-gray-50">
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
                                    <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
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
@endsection
