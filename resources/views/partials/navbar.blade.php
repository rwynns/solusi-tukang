<nav class="bg-white/90 shadow-lg py-4 px-6 fixed top-0 left-0 right-0 z-50 rounded-b-4xl">
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto mr-3 md:h-18">
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-2">
                <a href="/"
                    class="text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">Beranda</a>
                <a href=""
                    class="text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">Layanan</a>
                <a href=""
                    class="text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">Proyek</a>
                <a href=""
                    class="text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">Tentang
                    Kami</a>
                <a href=""
                    class="text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">Kontak</a>
            </div>

            <div class="hidden md:flex items-center">
                @auth
                    <div class="relative">
                        <button id="userDropdown"
                            class="flex items-center text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-2 rounded-xl transition-all font-poppins font-semibold focus:outline-none">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="userMenu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 z-10">
                            <a href="{{ route('profile') }}"
                                class="block px-4 py-2 text-sm text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60]/10 rounded-lg mx-1 my-1 font-poppins">Profil</a>

                            <a href="{{ Auth::user()->role_id == 1 ? route('admin.dashboard') : route('tukang.dashboard') }}"
                                class="block px-4 py-2 text-sm text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60]/10 rounded-lg mx-1 my-1 font-poppins">Dashboard</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60]/10 rounded-lg mx-1 my-1 font-poppins">
                                    Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login"
                        class="text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-6 py-2 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Masuk</a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobileMenuButton"
                    class="outline-none mobile-menu-button p-2 hover:bg-[#332E60]/10 rounded-xl transition-all">
                    <svg class="w-6 h-6 text-[#2A2C65] hover:text-[#F4C542]" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu with rounded bottom -->
    <div class="hidden mobile-menu md:hidden rounded-b-3xl overflow-hidden">
        <ul class="mt-4 pb-3 space-y-1 px-4">
            <li>
                <a href=""
                    class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                    Beranda
                </a>
            </li>
            <li>
                <a href=""
                    class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                    Layanan
                </a>
            </li>
            <li>
                <a href=""
                    class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                    Proyek
                </a>
            </li>
            <li>
                <a href=""
                    class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                    Tentang Kami
                </a>
            </li>
            <li>
                <a href=""
                    class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                    Kontak
                </a>
            </li>
            <div class="border-t border-gray-200 my-3"></div>
            @auth
                <li>
                    <a href="{{ route('profile') }}"
                        class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                        Profil
                    </a>
                </li>
                <li>
                    <a href="{{ Auth::user()->role_id == 1 ? route('admin.dashboard') : route('tukang.dashboard') }}"
                        class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                        Dashboard
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                            Keluar
                        </button>
                    </form>
                </li>
            @else
                <li>
                    <a href=""
                        class="block text-white bg-[#332E60] hover:bg-[#1D1B37] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase mb-2">
                        Masuk
                    </a>
                </li>
                <li class="mb-2">
                    <a href=""
                        class="block text-[#332E60] border border-[#332E60] hover:bg-[#332E60] hover:text-[#F4C542] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                        Daftar
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</nav>

<script>
    // Toggle dropdown menu
    const userDropdown = document.getElementById('userDropdown');
    const userMenu = document.getElementById('userMenu');

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (userDropdown && !userDropdown.contains(event.target) && userMenu && !userMenu.classList.contains(
                'hidden')) {
            userMenu.classList.add('hidden');
        }
    });

    if (userDropdown) {
        userDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');
        });
    }

    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
