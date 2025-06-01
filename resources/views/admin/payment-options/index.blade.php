@extends('layouts.dashboard')

@section('title', 'Payment Options')

@section('content')
    <!-- Page header -->
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold font-poppins text-gray-900">Kelola Payment Options</h1>
                </div>
                <a href="{{ route('payment-options.create') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium font-poppins rounded-md shadow-sm text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Payment Option
                </a>
            </div>
        </div>
    </div>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            @if (count($paymentOptions) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#292650]">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Account
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Logo
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                QR Code
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium font-poppins text-white uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($paymentOptions as $index => $option)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-roboto">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 font-roboto">{{ $option->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $option->account_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $option->account_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($option->logo)
                                        <img src="{{ Storage::url($option->logo) }}" alt="{{ $option->name }}"
                                            class="h-10 w-10 object-contain">
                                    @else
                                        <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($option->qr_code)
                                        <a href="{{ Storage::url($option->qr_code) }}" target="_blank"
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200">
                                            View QR
                                        </a>
                                    @else
                                        <span class="text-gray-400">No QR code</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <button type="button"
                                            class="toggle-status relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#F4C542] focus:ring-offset-2 {{ $option->is_active ? 'bg-green-500' : 'bg-gray-200' }}"
                                            data-id="{{ $option->id }}" role="switch"
                                            aria-checked="{{ $option->is_active ? 'true' : 'false' }}">
                                            <span class="sr-only">Toggle status</span>
                                            <span aria-hidden="true"
                                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $option->is_active ? 'translate-x-5' : 'translate-x-0' }}">
                                            </span>
                                        </button>
                                        <span
                                            class="ml-3 text-sm {{ $option->is_active ? 'text-green-800' : 'text-gray-500' }}">
                                            {{ $option->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('payment-options.edit', $option->id) }}"
                                            class="text-[#332E60] hover:text-[#292650]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('payment-options.destroy', $option->id) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900 delete-btn"
                                                data-id="{{ $option->id }}" data-name="{{ $option->name }}">
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
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        Tidak ada payment option
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan payment option baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('payment-options.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#332E60] hover:bg-[#292650] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F4C542]">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Tambah Payment Option
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
                    const optionId = this.getAttribute('data-id');
                    const optionName = this.getAttribute('data-name');
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan menghapus payment option "${optionName}"`,
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

            // Add event listeners to all toggle buttons
            const toggleButtons = document.querySelectorAll('.toggle-status');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const paymentOptionId = this.getAttribute('data-id');
                    const isCurrentlyActive = this.getAttribute('aria-checked') === 'true';
                    const toggleButton = this;
                    const statusText = this.nextElementSibling;

                    // Send AJAX request to toggle status
                    fetch(`/payment-options/${paymentOptionId}/toggle-status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update the toggle appearance
                                toggleButton.setAttribute('aria-checked', data.is_active ?
                                    'true' : 'false');
                                toggleButton.classList.toggle('bg-green-500', data.is_active);
                                toggleButton.classList.toggle('bg-gray-200', !data.is_active);

                                // Update the toggle knob position
                                const toggleKnob = toggleButton.querySelector(
                                    'span:not(.sr-only)');
                                toggleKnob.classList.toggle('translate-x-5', data.is_active);
                                toggleKnob.classList.toggle('translate-x-0', !data.is_active);

                                // Update the status text
                                statusText.textContent = data.is_active ? 'Active' : 'Inactive';
                                statusText.classList.toggle('text-green-800', data.is_active);
                                statusText.classList.toggle('text-gray-500', !data.is_active);

                                // Show success message
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: `Status updated to ${data.is_active ? 'active' : 'inactive'}`,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Failed to update status',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        });
                });
            });
        });
    </script>
@endsection
