<!-- resources/views/layouts/navbar.blade.php -->
<nav id="navbar" class="fixed w-full z-50 bg-[#007546]/90 backdrop-blur-md text-white transition-all duration-300 shadow-md">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('build/assets/channels4_profile.jpg') }}" alt="Logo" class="w-10 h-10 rounded-full">
            <span class="text-2xl font-bold px-4">DLH Garut</span>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-8 items-center">
            <a href="/" class="text-lg hover:text-[#F17025] transition-colors">Home</a>
            <a href="/dashboard" class="text-lg hover:text-[#F17025] transition-colors">Dashboard</a>
            <a href="/complaint" class="text-lg hover:text-[#F17025] transition-colors">Pengaduan</a>
            <a href="/article/list" class="text-lg hover:text-[#F17025] transition-colors">Artikel</a>
            <a href="#leaderboard" class="text-lg hover:text-[#F17025] transition-colors">Peringkat</a>
            <a href="#about" class="text-lg hover:text-[#F17025] transition-colors">Tentang</a>
            <a href="#guide" class="text-lg hover:text-[#F17025] transition-colors">Panduan</a>

            @auth
                @php
                    $user = Auth::user();

                    $currentLevel = \App\Models\Level::where('level', $user->level)->first();
                    $nextLevel = \App\Models\Level::where('level', $user->level + 1)->first();

                    $startExp = $currentLevel ? $currentLevel->required_exp : 0;
                    $endExp = $nextLevel ? $nextLevel->required_exp : $startExp;

                    $progress = $endExp > $startExp ? (($user->exp - $startExp) / ($endExp - $startExp)) * 100 : 100;

                    $maxExp = $endExp;
                @endphp

                <!-- Dropdown Profil -->
                <div class="relative inline-block text-left">
                    <button id="profileDropdownButton" class="flex items-center space-x-2 focus:outline-none relative">
                        <img src="{{ asset($user->avatar) }}" alt="Profile" class="avatar-sm relative w-8 h-8 rounded-full {{ $user->tier_border_class }}">
                        @if ($newComplaintsUserCount > 0)
                            <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center shadow-md">
                                {{ $newComplaintsUserCount }}
                            </span>
                        @endif
                        <span class="text-lg text-white hover:text-[#F17025]">Hi, {{ $user->name }} ▾</span>
                    </button>


                    <div id="profileDropdownMenu" class="absolute right-0 mt-3 w-72 bg-white rounded-lg shadow-xl z-10 hidden">
                        <div class="flex items-start p-4 border-b">
                            <img src="{{ asset($user->avatar) }}" alt="Profile" class="w-14 h-14 rounded-full mr-3 mt-1">

                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                                <p class="text-xs text-gray-600">Level: {{ $user->level }} | Points: {{ $user->points }}
                                </p>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-[#007546] h-2 rounded-full" style="width: {{ $progress }}%;"></div>
                                </div>
                                <p class="text-[10px] text-gray-500 mt-1">{{ $user->exp }} / {{ $maxExp }} EXP</p>
                            </div>
                        </div>
                        <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-[#007546] hover:bg-[#F0FDF4]">Lihat Profil</a>
                        <a href="{{ route('exchange-point.index') }}" class="block px-4 py-2 text-sm text-[#007546] hover:bg-[#F0FDF4]">Riwayat Penukaran</a>
                        <a href="{{ route('complaints.history') }}" class="relative block px-4 py-2 text-sm text-[#007546] hover:bg-[#F0FDF4]">Riwayat
                            @if ($newComplaintsUserCount > 0)
                                <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center shadow-md">
                                    {{ $newComplaintsUserCount }}
                                </span>
                            @endif
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-[#007546] hover:bg-[#F0FDF4]">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn bg-[#F17025] text-lg hover:text-[#007546] transition-colors mx-1">Login</a>
            @endauth
        </div>

        <!-- Hamburger Button -->
        <div class="md:hidden flex items-center">
            <button id="menu-button" class="focus:outline-none">
                <svg id="menu-icon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="menu-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden absolute top-16 left-0 w-full bg-white text-[#007546] px-4 py-6 z-40 space-y-4 transition-all duration-300">
        @auth
            <div class="flex items-start p-4">
                <img src="{{ asset($user->avatar) }}" alt="Profile" class="w-14 h-14 rounded-full mr-3 mt-1">
                <div class="flex-1 text-start">
                    <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                    <p class="text-xs text-gray-600">Level: {{ $user->level }} | Points: {{ $user->points }}</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-[#007546] h-2 rounded-full" style="width: {{ $progress }}%;"></div>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1">{{ $user->exp }} / {{ $maxExp }} EXP</p>
                </div>
            </div>
            <div class="border-t border-[#007546]/90 my-4 pt-4">
                <div class="mt-4 space-y-2">
                    <a href="{{ route('user.profile') }}" class="block text-sm text-[#007546] hover:text-[#F17025]">Lihat
                        Profil</a>
                    <a href="{{ route('complaints.history') }}" class="block text-sm text-[#007546] hover:text-[#F17025]">Riwayat</a>
                </div>
            </div>
        @endauth
        <a href="/" class="block text-[#007546]/90 hover:text-[#F17025]">Home</a>
        <a href="/complaint" class="block text-[#007546]/90 hover:text-[#F17025]">Pengaduan</a>
        <a href="/article" class="block text-[#007546]/90 hover:text-[#F17025]">Artikel</a>
        <a href="#" class="block text-[#007546]/90 hover:text-[#F17025]">Leaderboard</a>
        <a href="#about" class="block text-[#007546]/90 hover:text-[#F17025]">Tentang Aplikasi</a>
        <a href="#guide" class="block text-[#007546]/90 hover:text-[#F17025]">Panduan</a>
        @auth
            <form action="{{ route('logout') }}" method="POST" class="flex justify-center">
                @csrf
                <button type="submit" class="btn bg-[#F17025] text-lg text-white hover:text-[#007546] transition-colors px-6 py-2 rounded">
                    Logout
                </button>
            </form>
        @endauth
        @guest
            <div class="border-t border-[#007546]/90 my-4"></div>
            <div class="md:flex items-center">
                <a href="/login" class="btn bg-[#F17025] text-lg hover:text-[#007546] transition-colors">login</a>
            </div>
        @endguest
    </div>
</nav>
