@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-100">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold font-poppins leading-6 text-gray-900">Informasi Profil</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 font-roboto">Detail lengkap profil Anda.</p>
                    </div>
                    <div>
                        <a href="{{ route('profile.edit') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Profil
                        </a>
                    </div>
                </div>

                <div class="border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                        <!-- Kolom Foto Profil -->
                        <div class="flex flex-col items-center justify-start space-y-4">
                            <div
                                class="h-48 w-48 rounded-full overflow-hidden bg-gray-100 border-4 border-[#F3BD2B] shadow-lg">
                                @if ($user->tukangProfile && $user->tukangProfile->profile_photo)
                                    <img src="{{ asset('storage/' . $user->tukangProfile->profile_photo) }}"
                                        alt="{{ $user->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full bg-[#F3BD2B] flex items-center justify-center">
                                        <span class="text-5xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="text-center">
                                <h2 class="text-2xl font-bold font-poppins text-gray-900">{{ $user->name }}</h2>
                                <p class="text-sm text-gray-500 font-roboto">Bergabung sejak
                                    {{ $user->created_at->format('d M Y') }}</p>
                            </div>

                            <div class="w-full bg-gray-50 rounded-lg p-4 mt-4">
                                <h3 class="text-lg font-semibold font-poppins text-gray-900 mb-2">Keahlian</h3>
                                <div class="flex flex-wrap gap-2">
                                    @if ($user->tukangProfile && $user->tukangProfile->skills->isNotEmpty())
                                        @foreach ($user->tukangProfile->skills as $skill)
                                            <span class="px-2 py-1 text-sm rounded-full bg-[#332E60] text-white">
                                                {{ $skill->name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-sm text-gray-500">Belum ada keahlian</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Informasi -->
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 rounded-lg p-6 h-full">
                                <div class="grid grid-cols-1 gap-y-6">
                                    <div>
                                        <h3 class="text-lg font-semibold font-poppins text-gray-900 mb-3">Informasi Dasar
                                        </h3>
                                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                                <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $user->name }}
                                                </dd>
                                            </div>
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                                            </div>
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    {{ $user->phone_number ?? 'Belum diisi' }}</dd>
                                            </div>
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">Lokasi</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $user->tukangProfile && $user->tukangProfile->location ? $user->tukangProfile->location->name : 'Belum diatur' }}
                                                    </span>
                                                </dd>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    {{ $user->address ?? 'Belum diisi' }}</dd>
                                            </div>
                                        </dl>
                                    </div>

                                    <div class="border-t border-gray-200 pt-6">
                                        <h3 class="text-lg font-semibold font-poppins text-gray-900 mb-3">Bio / Deskripsi
                                        </h3>
                                        <div class="prose max-w-none text-sm text-gray-700">
                                            @if ($user->tukangProfile && $user->tukangProfile->bio)
                                                <p>{{ $user->tukangProfile->bio }}</p>
                                            @else
                                                <p class="text-gray-500 italic">Bio belum diisi</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="border-t border-gray-200 pt-6">
                                        <h3 class="text-lg font-semibold font-poppins text-gray-900 mb-3">Aktivitas Akun
                                        </h3>
                                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">Terdaftar Sejak</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    {{ $user->created_at->format('d M Y') }}</dd>
                                            </div>
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    {{ $user->updated_at->format('d M Y, H:i') }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
