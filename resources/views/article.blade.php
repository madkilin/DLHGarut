<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav id="navbar"
        class="fixed w-full z-50 bg-[#007546]/90 backdrop-blur-md text-white transition-all duration-300 shadow-md">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('build/assets/channels4_profile.jpg') }}" alt="Logo"
                    class="w-10 h-10 rounded-full">
                <span class="text-2xl font-bold px-4">DLH Garut</span>
            </div>
            <div class="hidden md:flex space-x-8 items-center">



                <a href="#" class="text-lg hover:text-[#F17025] transition-colors">Home</a>
                <a href="#" class="text-lg hover:text-[#F17025] transition-colors">Artikel</a>
                <a href="#leaderboard" class="text-lg hover:text-[#F17025] transition-colors">Leaderboard</a>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileButton" class="text-lg hover:text-[#F17025] focus:outline-none">Profile
                        ▾</button>
                    <div id="profileMenu"
                        class="absolute hidden bg-white text-black mt-2 rounded-md shadow-lg right-0 min-w-[150px]">
                        <a href="#" class="block px-4 py-2 text-[#007546] hover:bg-gray-100 rounded-lg">Lihat Profil</a>
                        <a href="#" class="block px-4 py-2 text-[#007546] hover:bg-gray-100">Setting</a>
                        <a href="#" class="block px-4 py-2 text-[#007546] hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="menu-button" class="focus:outline-none">
                    <svg id="menu-icon" class="w-8 h-8 transition-all" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path id="menu-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu"
            class="hidden md:hidden bg-white backdrop-blur-md px-4 py-6 space-y-4 transition-all duration-500 text-center">
            <a href="#" class="block text-[#007546]/90 hover:text-[#F17025]">Home</a>
            <a href="#" class="block text-[#007546]/90 hover:text-[#F17025]">Artikel</a>
            <a href="#" class="block text-[#007546]/90 hover:text-[#F17025]">Leaderboard</a>
            <div class="border-t border-[#007546]/90 my-4"></div>
            <a href="#" class="block text-[#007546]/90 hover:text-[#F17025]">Lihat Profil</a>
            <a href="#" class="block text-[#007546]/90 hover:text-[#F17025]">Setting</a>
            <a href="#" class="block text-[#007546]/90 hover:text-[#F17025]">Logout</a>
        </div>

    </nav>
    <main class="flex-1 mt-16">
<!-- Artikel Section -->
<section id="artikel" class="relative bg-gradient-to-br from-white via-green-50 to-white py-24 overflow-hidden">
    <div class="container mx-auto px-6 md:px-16">
        <!-- Highlight Artikel -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-[#007546] mb-4">Artikel Terbaru</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Dapatkan informasi terkini dan bermanfaat seputar lingkungan, pengelolaan sampah, dan kegiatan DLH Garut.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-20">
            <!-- Ulangi Card Ini untuk Highlight -->
            @for ($i = 1; $i <= 4; $i++)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition hover:shadow-2xl hover:scale-[1.01] duration-300">
                <img src="{{ asset('build/assets/artikel' . $i . '.jpg') }}" alt="Artikel {{ $i }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-[#007546] mb-2">Judul Artikel {{ $i }}</h3>
                    <p class="text-gray-700 text-sm mb-4">Deskripsi singkat artikel ke-{{ $i }}. Ringkasan isi dari artikel yang ditampilkan di bagian highlight.</p>
                    <a href="#" class="text-[#F17025] font-semibold hover:underline">Baca Selengkapnya →</a>
                </div>
            </div>
            @endfor
        </div>

        <!-- Semua Artikel -->
        <div class="text-center mb-10">
            <h3 class="text-3xl font-bold text-[#007546] mb-4">Artikel Doang</h3>
            <p class="text-gray-600 max-w-xl mx-auto">Telusuri seluruh artikel yang kami miliki untuk memperluas informasi dan wawasan Anda tentang lingkungan dan pengelolaannya.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Ulangi Card Ini untuk Semua Artikel -->
            @for ($i = 5; $i <= 12; $i++)
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition hover:shadow-lg hover:scale-[1.01] duration-300">
                <img src="{{ asset('build/assets/artikel' . $i . '.jpg') }}" alt="Artikel {{ $i }}" class="w-full h-36 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-semibold text-[#007546] mb-1">Judul Artikel {{ $i }}</h4>
                    <p class="text-gray-600 text-sm mb-3">Deskripsi pendek dari artikel ke-{{ $i }} untuk tampilan daftar artikel lengkap.</p>
                    <a href="#" class="text-[#F17025] text-sm font-semibold hover:underline">Baca Selengkapnya →</a>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Decorative SVG Wave -->
    <div class="absolute top-0 left-0 w-full overflow-hidden leading-none" style="height: 80px;">
        <svg class="relative block w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
            <path fill="#bbf7d0" d="M0,32L60,48C120,64,240,64,360,48C480,32,600,0,720,0C840,0,960,32,1080,53.3C1200,75,1320,85,1380,90L1440,96V0H1380C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0H0Z"></path>
        </svg>
    </div>
</section>

    </main>
</body>