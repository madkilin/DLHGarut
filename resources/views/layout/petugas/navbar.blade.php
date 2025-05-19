<nav id="navbar"
    class="fixed w-full z-50 bg-[#007546]/90 backdrop-blur-md text-white transition-all duration-300 shadow-md">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('build/assets/channels4_profile.jpg') }}" alt="Logo" class="w-10 h-10 rounded-full">
            <span class="text-2xl font-bold px-4">DLH Garut</span>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-8 items-center">
            <a href="{{ route('petugas.dashboard') }}" class="text-lg hover:text-[#F17025] transition-colors">Home</a>
            <a href="{{route('petugas.complaints.index')}}" class="text-lg hover:text-[#F17025] transition-colors">Manajemen Pengaduan</a>
            <a href="#" class="text-lg hover:text-[#F17025] transition-colors">Manajemen Artikel</a>

            @auth
                @php
                    $user = Auth::user();
                @endphp

                <!-- Dropdown Profil -->
                <div class="relative inline-block text-left">
                    <button id="profileDropdownButton" class="flex items-center space-x-2 focus:outline-none">
                        <img src="{{ asset('storage/profile_photos/' . ($user->profile_photo ?? 'default_image/default_profile.jpg')) }}"
                            alt="Profile" class="w-8 h-8 rounded-full">
                        <span class="text-lg text-white hover:text-[#F17025]">Hi, {{ $user->name }} ▾</span>
                    </button>

                    <div id="profileDropdownMenu"
                        class="absolute right-0 mt-3 w-72 bg-white rounded-lg shadow-xl z-10 hidden">
                        <div class="flex items-start p-4 border-b">
                            <img src="{{ asset('storage/profile_photos/' . ($user->profile_photo ?? 'default_image/default_profile.jpg')) }}"
                                alt="Profile" class="w-14 h-14 rounded-full mr-3 mt-1">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                                <p class="text-xs text-gray-600">Admin</p>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-[#007546] hover:bg-[#F0FDF4]">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Hamburger Button -->
        <div class="md:hidden flex items-center">
            <button id="menu-button" class="focus:outline-none">
                <svg id="menu-icon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="menu-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden md:hidden absolute top-16 left-0 w-full bg-white text-[#007546] px-4 py-6 z-40 space-y-4 transition-all duration-300">
        @auth
            <div class="flex items-start p-4">
                <img src="{{ asset('storage/profile_photos/' . ($user->profile_photo ?? 'default_image/default_profile.jpg')) }}"
                    alt="Profile" class="w-14 h-14 rounded-full mr-3 mt-1">
                <div class="flex-1 text-start">
                    <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                    <p class="text-xs text-gray-600">Admin</p>
                </div>
            </div>
        @endauth

        <div class="border-t border-[#007546]/90 my-4 pt-4 space-y-4">
            <a href="{{ route('petugas.dashboard') }}" class="block text-[#007546]/90 hover:text-[#F17025]">Home</a>
            <a href="{{route('petugas.complaints.index')}}" class="block text-[#007546]/90 hover:text-[#F17025]">Manajemen Pengaduan</a>
            <a href="#" class="block text-[#007546]/90 hover:text-[#F17025]">Manajemen Artikel</a>
        </div>

        @auth
            <form action="{{ route('logout') }}" method="POST" class="flex justify-center mt-4">
                @csrf
                <button type="submit"
                    class="btn bg-[#F17025] text-lg text-white hover:text-[#007546] transition-colors px-6 py-2 rounded">
                    Logout
                </button>
            </form>
        @endauth
    </div>
</nav>
