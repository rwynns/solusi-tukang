@extends('layouts.main')
@section('content')
    <section class="relative h-screen overflow-hidden">
        <!-- Background image -->
        <div class="absolute inset-0 w-full h-full">
            <img src="{{ asset('images/hero-bg.png') }}" alt="Hero Background" class="w-full h-full object-cover grayscale-50">
            <!-- Overlay to make text more readable -->
            <div class="absolute inset-0 bg-black/40"></div>
        </div>

        <!-- Content centered both horizontally and vertically -->
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
@endsection
