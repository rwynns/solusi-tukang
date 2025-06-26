@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-6 md:px-12 py-16">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-[#332E60] mb-4 font-poppins text-center">Kirim
                <span class="text-[#F4C542]">Ulasan</span> Anda
            </h2>
            <p class="text-gray-600 max-w-3xl mx-auto text-center mb-8">Kami menghargai masukan Anda. Bagikan pengalaman Anda
                dengan
                layanan kami untuk membantu kami terus meningkatkan kualitas.</p>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 md:p-8">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
                            role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('reviews.guest.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Ulasan</label>
                            <textarea id="content" name="content" rows="4" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#F4C542] focus:border-[#F4C542]"
                                placeholder="Bagikan pengalaman Anda dengan layanan kami...">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Min. 5 karakter</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-[#332E60] hover:bg-[#28244D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-9 3a1 1 0 102 0V7a1 1 0 10-2 0v6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
