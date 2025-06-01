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

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <!-- Reviews Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            @if (isset($reviews) && count($reviews) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#292650]">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Nomor Pemesanan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Ulasan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reviews as $review)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 font-roboto">
                                        {{ $review->order->user->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $review->order->user->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 font-roboto">
                                        <a href="{{ route('admin.orders.show', $review->order_id) }}"
                                            class="text-[#332E60] hover:underline">
                                            {{ $review->order->order_number }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs">
                                        {{ $review->content }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-roboto text-gray-900">
                                        {{ $review->created_at->format('d M Y, H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
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
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <div class="text-center py-12">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada ulasan ditemukan
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada ulasan yang diberikan pelanggan.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada ulasan ditemukan</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada ulasan yang diberikan pelanggan.</p>
                </div>
            @endif
        </div>
    </main>
@endsection
