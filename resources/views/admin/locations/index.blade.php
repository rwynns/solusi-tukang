@extends('layouts.dashboard')

@section('title', 'Kelola Lokasi')

@section('content')
    <!-- Page header -->
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold font-poppins text-gray-900 text-shadow-md">Kelola Lokasi</h1>
                <a href="{{ route('locations.create') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium font-poppins rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6">
                        <path fill-rule="evenodd"
                            d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Lokasi
                </a>
            </div>
        </div>
    </div>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="bg-white px-4 py-3 shadow rounded-lg mb-6">
            <form action="{{ route('locations.index') }}" method="GET"
                class="flex flex-col sm:flex-row gap-4 items-center">
                <div class="flex-1">
                    <label for="search" class="sr-only">Cari</label>
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
                            placeholder="Cari lokasi...">
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 h-10 border border-transparent text-sm font-medium font-poppins rounded-md shadow-sm bg-[#F3BD2B] hover:bg-[#e0b53d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            @if (count($locations) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#292650]">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Nama
                                Lokasi</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Dibuat Pada</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($locations as $index => $location)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-roboto">
                                    {{ $index + $locations->firstItem() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-roboto">{{ $location->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-roboto">{{ $location->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('locations.edit', $location) }}"
                                            class="text-[#332E60] hover:text-[#292650]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('locations.destroy', $location) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900 delete-btn"
                                                data-id="{{ $location->id }}" data-name="{{ $location->name }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
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
                    {{ $locations->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data lokasi</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan lokasi baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('locations.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Tambah Lokasi
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
            // Add event listeners to all delete buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const locationId = this.getAttribute('data-id');
                    const locationName = this.getAttribute('data-name');
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan menghapus lokasi "${locationName}"`,
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
