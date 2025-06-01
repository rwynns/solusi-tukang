@extends('layouts.dashboard')

@section('title', 'Detail Tukang')

@section('content')
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Detail Tukang</h1>
                <a href="{{ route('tukang.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium font-poppins rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z"
                            clip-rule="evenodd" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-100">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold font-poppins leading-6 text-gray-900">Informasi Tukang</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 font-roboto">Detail lengkap profil tukang.</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('tukang.edit', $tukang) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('tukang.destroy', $tukang) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 delete-btn"
                                data-id="{{ $tukang->id }}" data-name="{{ $tukang->name }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <div class="border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                        <!-- Kolom Foto Profil -->
                        <div class="flex flex-col items-center justify-start space-y-4">
                            <div
                                class="h-48 w-48 rounded-full overflow-hidden bg-gray-100 border-4 border-[#F3BD2B] shadow-lg">
                                @if ($tukang->tukangProfile->profile_photo)
                                    <img src="{{ Storage::url($tukang->tukangProfile->profile_photo) }}"
                                        alt="{{ $tukang->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full bg-[#F3BD2B] flex items-center justify-center">
                                        <span
                                            class="text-5xl font-bold text-[#332E60]">{{ substr($tukang->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="text-center">
                                <h2 class="text-2xl font-bold font-poppins text-gray-900">{{ $tukang->name }}</h2>
                                <p class="text-sm text-gray-500 font-roboto">Bergabung sejak
                                    {{ $tukang->created_at->format('d M Y') }}</p>
                            </div>

                            <div class="w-full bg-gray-50 rounded-lg p-4 mt-4">
                                <h3 class="text-lg font-semibold font-poppins text-gray-900 mb-2">Keahlian</h3>
                                <div class="flex flex-wrap gap-2">
                                    @forelse ($tukang->tukangProfile->skills as $skill)
                                        <span class="px-2 py-1 text-sm rounded-full bg-[#332E60] text-white">
                                            {{ $skill->nama }}
                                        </span>
                                    @empty
                                        <span class="text-sm text-gray-500">Belum ada keahlian</span>
                                    @endforelse
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
                                                <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $tukang->name }}
                                                </dd>
                                            </div>
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $tukang->email }}</dd>
                                            </div>
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $tukang->phone_number }}</dd>
                                            </div>
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">Lokasi</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $tukang->tukangProfile->location->name ?? 'Belum diatur' }}
                                                    </span>
                                                </dd>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $tukang->address }}</dd>
                                            </div>
                                        </dl>
                                    </div>

                                    <div class="border-t border-gray-200 pt-6">
                                        <h3 class="text-lg font-semibold font-poppins text-gray-900 mb-3">Bio / Deskripsi
                                        </h3>
                                        <div class="prose max-w-none text-sm text-gray-700">
                                            @if ($tukang->tukangProfile->bio)
                                                <p>{{ $tukang->tukangProfile->bio }}</p>
                                            @else
                                                <p class="text-gray-500 italic">Bio belum diisi</p>
                                            @endif
                                        </div>
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to delete button
            const deleteBtn = document.querySelector('.delete-btn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    const tukangId = this.getAttribute('data-id');
                    const tukangName = this.getAttribute('data-name');
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan menghapus tukang "${tukangName}"`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, submit the form
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>
@endsection
