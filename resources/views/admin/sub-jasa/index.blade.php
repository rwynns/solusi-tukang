@extends('layouts.dashboard')

@section('title', isset($title) ? $title : 'Kelola Sub Jasa')

@section('content')
    <!-- Page header -->
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold font-poppins text-gray-900">
                        {{ isset($title) ? $title : 'Kelola Sub Jasa' }}</h1>
                    @if (request()->has('jasa_id'))
                        <a href="{{ route('sub-jasa.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                            Lihat semua sub jasa
                        </a>
                    @endif
                </div>
                <a href="{{ route('sub-jasa.create', request()->has('jasa_id') ? ['jasa_id' => request('jasa_id')] : []) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium font-poppins rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Sub Jasa
                </a>
            </div>
        </div>
    </div>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="bg-white px-4 py-3 shadow rounded-lg mb-6">
            <form action="{{ route('sub-jasa.index') }}" method="GET"
                class="flex flex-col sm:flex-row gap-4 items-center">
                @if (request()->has('jasa_id'))
                    <input type="hidden" name="jasa_id" value="{{ request('jasa_id') }}">
                @else
                    <div class="w-full sm:w-1/3">
                        <label for="jasa_id" class="block text-xs font-medium text-gray-700 mb-1">Filter Jasa</label>
                        <select id="jasa_id" name="jasa_id"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F4C542] focus:ring-[#F4C542] sm:text-sm h-10">
                            <option value="">Semua Jasa</option>
                            @foreach (App\Models\Jasa::orderBy('nama')->get() as $jasa)
                                <option value="{{ $jasa->id }}" {{ request('jasa_id') == $jasa->id ? 'selected' : '' }}>
                                    {{ $jasa->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex-1">
                    <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Cari Sub Jasa</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="focus:ring-[#F4C542] focus:border-[#F4C542] block w-full h-10 pl-10 sm:text-sm border-gray-300 rounded-md font-roboto"
                            placeholder="Cari sub jasa...">
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <label class="block text-xs font-medium text-gray-700 mb-1 opacity-0">Aksi</label>
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 h-10 border border-transparent text-sm font-medium font-poppins rounded-md shadow-sm bg-[#F3BD2B] hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            @if (count($subJasaList) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#292650]">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Gambar
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Nama Sub Jasa
                            </th>
                            @if (!request()->has('jasa_id'))
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                    Jasa Utama
                                </th>
                            @endif
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Harga
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($subJasaList as $index => $subJasa)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-roboto">
                                    {{ $index + $subJasaList->firstItem() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex-shrink-0 h-20 w-20">
                                        @if ($subJasa->gambar)
                                            <img class="w-20 h-20 rounded-md object-cover"
                                                src="{{ Storage::url($subJasa->gambar) }}" alt="{{ $subJasa->nama }}">
                                        @else
                                            <div class="h-14 w-14 rounded-md bg-gray-200 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 font-roboto">{{ $subJasa->nama }}</div>
                                </td>
                                @if (!request()->has('jasa_id'))
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('sub-jasa.index', ['jasa_id' => $subJasa->jasa_id]) }}"
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200">
                                            {{ $subJasa->jasa->nama }}
                                        </a>
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 font-mono">Rp
                                        {{ number_format($subJasa->harga, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-roboto text-gray-900 line-clamp-4">
                                        {{ $subJasa->deskripsi ?? 'Tidak ada deskripsi' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <!-- Tombol Detail -->
                                        <a href="{{ route('sub-jasa.show', $subJasa) }}"
                                            class="text-blue-600 hover:text-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('sub-jasa.edit', $subJasa) }}"
                                            class="text-[#332E60] hover:text-[#292650]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('sub-jasa.destroy', $subJasa) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900 delete-btn"
                                                data-id="{{ $subJasa->id }}" data-name="{{ $subJasa->nama }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $subJasaList->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        Tidak ada data sub jasa
                        @if (request()->has('jasa_id'))
                            untuk jasa ini
                        @endif
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan sub jasa baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('sub-jasa.create', request()->has('jasa_id') ? ['jasa_id' => request('jasa_id')] : []) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Tambah Sub Jasa
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit form when jasa_id changes
            const jasaSelect = document.getElementById('jasa_id');
            if (jasaSelect) {
                jasaSelect.addEventListener('change', function() {
                    this.form.submit();
                });
            }

            // Add event listeners to all delete buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const subJasaId = this.getAttribute('data-id');
                    const subJasaNama = this.getAttribute('data-name');
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan menghapus sub jasa "${subJasaNama}"`,
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
            });
        });
    </script>
@endsection
