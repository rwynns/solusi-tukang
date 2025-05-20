@extends('layouts.dashboard')

@section('title', 'Detail Jasa')

@section('content')
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Detail Jasa</h1>
                <a href="{{ route('kelola-jasa.index') }}"
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

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 font-poppins">Informasi Jasa</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 font-roboto">Detail lengkap jasa yang ditawarkan.</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('kelola-jasa.edit', $jasa) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a>

                        <form action="{{ route('kelola-jasa.destroy', $jasa) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 delete-btn"
                                data-id="{{ $jasa->id }}" data-name="{{ $jasa->nama }}">
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
                    <div class="py-6 px-4 sm:px-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Kolom Gambar -->
                            <div class="md:col-span-1">
                                <div class="overflow-hidden rounded-lg bg-gray-100 border border-gray-200 h-60">
                                    @if ($jasa->gambar)
                                        <img src="{{ Storage::url($jasa->gambar) }}" alt="{{ $jasa->nama }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full bg-gray-50">
                                            <svg class="h-24 w-24 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Kolom Informasi -->
                            <div class="md:col-span-2">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500 font-poppins">Nama Jasa</dt>
                                        <dd class="mt-1 text-lg font-semibold text-gray-900 font-roboto">{{ $jasa->nama }}
                                        </dd>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500 font-poppins">Slug</dt>
                                        <dd
                                            class="mt-1 text-sm text-gray-900 bg-gray-50 p-2 rounded border border-gray-200 font-mono">
                                            {{ $jasa->slug }}</dd>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500 font-poppins">Dibuat Pada</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-roboto">
                                            {{ $jasa->created_at->format('d F Y, H:i') }}</dd>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500 font-poppins">Terakhir Diperbarui</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-roboto">
                                            {{ $jasa->updated_at->format('d F Y, H:i') }}</dd>
                                    </div>

                                    <div class="sm:col-span-2 border-t border-gray-200 pt-4">
                                        <dt class="text-sm font-medium text-gray-500 font-poppins">Deskripsi</dt>
                                        <dd class="mt-2 text-gray-900 font-roboto space-y-3">
                                            {!! nl2br(e($jasa->deskripsi)) !!}
                                        </dd>
                                    </div>
                                </dl>
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
            // Add event listener to delete button
            const deleteBtn = document.querySelector('.delete-btn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    const jasaId = this.getAttribute('data-id');
                    const jasaNama = this.getAttribute('data-name');
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan menghapus jasa "${jasaNama}"`,
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
