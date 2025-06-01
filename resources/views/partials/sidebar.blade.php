<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
        <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-[#332E60] border-r">
            <!-- Logo di bagian atas -->
            <div class="flex items-center flex-shrink-0 px-4">
                <a href="{{ route('home') }}" class="text-white">
                    <img src="{{ asset('images/logo-white.png') }}" alt="Logo" class="h-14 w-auto mr-3 md:h-18">
                </a>
            </div>

            <!-- Menu utama sesuai role -->
            <div class="mt-8 flex flex-col flex-1">
                <nav class="flex-1 px-2 space-y-1">
                    @if (Auth::user()->role_id == 1)
                        <!-- Admin Menu Items -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ request()->routeIs('admin.dashboard') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('admin.orders.index') }}"
                            class="{{ request()->routeIs('admin.orders.*') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                            Pesanan
                        </a>

                        <!-- Menu admin lainnya -->
                        <a href="{{ route('tukang.index') }}"
                            class="{{ request()->routeIs('tukang.*') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Tukang
                        </a>

                        <a href="{{ route('locations.index') }}"
                            class="{{ request()->routeIs('locations.*') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            Lokasi
                        </a>

                        <a href="{{ route('kelola-jasa.index') }}"
                            class="{{ request()->routeIs('kelola-jasa.*') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                            </svg>
                            Jasa
                        </a>

                        <a href="{{ route('sub-jasa.index') }}"
                            class="{{ request()->routeIs('sub-jasa.*') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                            Sub Jasa
                        </a>

                        <a href="{{ route('payment-options.index') }}"
                            class="{{ request()->routeIs('payment-options.*') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                            </svg>
                            Pilihan Pembayaran
                        </a>

                        <a href="{{ route('admin.reviews.index') }}"
                            class="{{ request()->routeIs('admin.reviews.*') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                            </svg>
                            Ulasan Pelanggan
                        </a>
                    @elseif(Auth::user()->role_id == 2)
                        <!-- Menu Tukang -->
                        <a href="{{ route('tukang.pesanan.index') }}"
                            class="{{ request()->routeIs('tukang.pesanan.*') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                            Pesanan Saya
                        </a>

                        <a href="{{ route('profile') }}"
                            class="{{ request()->routeIs('profile') && !request()->routeIs('profile.edit') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Profil Saya
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="{{ request()->routeIs('profile.edit') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Edit Profil
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Bagian bawah: Link Beranda + User Info -->
            <div class="mt-auto">
                <!-- Link Beranda yang dipindahkan ke bawah -->
                <div class="px-2 py-2">
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'bg-[#3e3777] text-white' : 'text-gray-300 hover:bg-[#3e3777] hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="mr-3 h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Beranda
                    </a>
                </div>

                <!-- Informasi User Login -->
                <div class="flex-shrink-0 block px-4 py-4 border-t border-[#3e3777]">
                    <div class="flex items-center">
                        <div>
                            <div
                                class="rounded-full h-9 w-9 flex items-center justify-center bg-[#F3BD2B] text-[#332E60] font-bold font-roboto">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white font-roboto">{{ Auth::user()->name ?? 'User' }}
                            </p>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-xs font-medium text-gray-300 hover:text-white font-roboto">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
