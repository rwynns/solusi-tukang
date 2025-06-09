@extends('layouts.dashboard')

@section('title', 'Kelola Ulasan Pelanggan')

@section('content')
    <!-- Page header -->
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold font-poppins text-gray-900">Kelola Ulasan Pelanggan</h1>
            </div>
        </div>
    </div>

    <main class="flex-1 overflow-y-auto p-2 sm:p-4 lg:p-8 bg-gray-50">
        <!-- Responsive Table Wrapper -->
        <div class="bg-white shadow overflow-x-auto sm:rounded-lg">
            @if (isset($reviews) && count($reviews) > 0)
                <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                    <thead class="bg-[#292650]">
                        <tr>
                            <th scope="col"
                                class="px-2 py-3 sm:px-6 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider whitespace-nowrap">
                                Pelanggan
                            </th>
                            <th scope="col"
                                class="px-2 py-3 sm:px-6 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider whitespace-nowrap">
                                Nomor Pemesanan
                            </th>
                            <th scope="col"
                                class="px-2 py-3 sm:px-6 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider whitespace-nowrap">
                                Ulasan
                            </th>
                            <th scope="col"
                                class="px-2 py-3 sm:px-6 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider whitespace-nowrap">
                                Tanggal
                            </th>
                            <th scope="col"
                                class="px-2 py-3 sm:px-6 text-right text-xs font-medium font-poppins text-white uppercase tracking-wider whitespace-nowrap">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reviews as $review)
                            <tr>
                                <td class="px-2 py-4 sm:px-6 whitespace-nowrap align-top">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 font-roboto">
                                        {{ $review->order->user->name }}
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500 mt-1">
                                        {{ $review->order->user->email }}
                                    </div>
                                </td>
                                <td class="px-2 py-4 sm:px-6 whitespace-nowrap align-top">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 font-roboto">
                                        <a href="{{ route('admin.orders.show', $review->order_id) }}"
                                            class="text-[#332E60] hover:underline break-all">
                                            {{ $review->order->order_number }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-2 py-4 sm:px-6 align-top max-w-xs break-words">
                                    <div class="text-xs sm:text-sm text-gray-900">
                                        {{ $review->content }}
                                    </div>
                                </td>
                                <td class="px-2 py-4 sm:px-6 whitespace-nowrap align-top">
                                    <div class="text-xs sm:text-sm font-roboto text-gray-900">
                                        {{ $review->created_at->format('d M Y, H:i') }}
                                    </div>
                                </td>
                                <td
                                    class="px-2 py-4 sm:px-6 whitespace-nowrap text-right text-xs sm:text-sm font-medium align-top">
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-2 py-4 sm:px-6 whitespace-nowrap text-xs sm:text-sm text-gray-500 text-center">
                                    <div class="text-center py-12">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 class="mt-2 text-xs sm:text-sm font-medium text-gray-900">Tidak ada ulasan
                                            ditemukan
                                        </h3>
                                        <p class="mt-1 text-xs sm:text-sm text-gray-500">Belum ada ulasan yang diberikan
                                            pelanggan.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="bg-white px-2 py-3 sm:px-6 border-t border-gray-200">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-xs sm:text-sm font-medium text-gray-900">Tidak ada ulasan ditemukan</h3>
                    <p class="mt-1 text-xs sm:text-sm text-gray-500">Belum ada ulasan yang diberikan pelanggan.</p>
                </div>
            @endif
        </div>
    </main>
@endsection
