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
                <a href="#" class="text-lg hover:text-[#F17025] transition-colors">Leaderboard</a>

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

    <!-- Main Content -->
    <main class="flex-1 mt-16">

        <!-- Section 1 -->
        <section class="relative bg-gradient-to-br from-green-100 via-green-200 to-green-100 py-24 overflow-hidden">
            <div class="container mx-auto flex flex-col-reverse md:flex-row items-center px-6 md:px-16">

                <!-- Kiri: Deskripsi -->
                <div class="w-full md:w-1/2 text-center md:text-left mb-10 md:mb-0 animate-fade-up px-4">
                    <h2 class="text-5xl font-extrabold mb-6 leading-tight text-[#F17025]">Selamat Datang di Website
                        Kami!</h2>
                    <p class="text-lg text-gray-700 mb-8">
                        Ini adalah platform terbaik untuk mengeksplorasi artikel, melihat leaderboard, dan mengelola
                        profil Anda dengan mudah. Nikmati pengalaman baru yang menyenangkan bersama kami!
                    </p>
                    <div class="flex justify-center md:justify-start">
                        <a href="#explore"
                            class="inline-block bg-[#F17025] hover:bg-[#F17025] text-white font-semibold px-6 py-3 rounded-full shadow-lg transition-all duration-300">Mulai
                            Jelajahi</a>
                    </div>
                </div>

                <!-- Kanan: Gambar Ilustrasi -->
                <div class="w-full md:w-1/2 flex justify-center md:justify-end relative py-4">
                    <img src="{{ asset('build/assets/ilstrasi aja.webp') }}" alt="Ilustrasi Website"
                        class="max-w-full h-auto rounded-3xl shadow-2xl">
                    <!-- Floating decorative SVG -->
                    <svg class="absolute top-0 right-0 w-32 h-32 opacity-20 transform translate-x-12 -translate-y-12"
                        viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#86efac"
                            d="M39.5,-56.9C52.8,-47.4,65.5,-39.2,72.1,-27.2C78.8,-15.1,79.3,0.9,71.9,13.5C64.5,26.1,49.2,35.2,35.7,46.6C22.1,58,11.1,71.8,-2.5,75.2C-16,78.5,-32.1,71.3,-45.8,60.4C-59.5,49.5,-70.9,35,-74.9,18.8C-78.8,2.7,-75.3,-15.1,-65.3,-29.2C-55.4,-43.4,-38.9,-53.9,-22.4,-61.7C-5.9,-69.5,10.5,-74.6,24.7,-70.8C38.9,-66.9,51.1,-54.4,39.5,-56.9Z"
                            transform="translate(100 100)" />
                    </svg>
                </div>

            </div>
            <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180" style="height: 80px;">
                <svg class="relative block w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80"
                    preserveAspectRatio="none">
                    <path fill="#bbf7d0"
                        d="M0,32L60,48C120,64,240,64,360,48C480,32,600,0,720,0C840,0,960,32,1080,53.3C1200,75,1320,85,1380,90L1440,96V0H1380C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0H0Z">
                    </path>
                </svg>
            </div>
        </section>

        <!-- Section 2 - Carousel 4 Card, Geser 1 Card -->
        <section class="relative bg-gradient-to-b from-white to-green-50 text-gray-800 py-24 overflow-hidden">
            <!-- SVG Wave Top -->
            <div class="absolute top-0 left-0 w-full overflow-hidden leading-none " style="height: 80px;">
                <svg class="relative block w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80"
                    preserveAspectRatio="none">
                    <path fill="#bbf7d0"
                        d="M0,32L60,48C120,64,240,64,360,48C480,32,600,0,720,0C840,0,960,32,1080,53.3C1200,75,1320,85,1380,90L1440,96V0H1380C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0H0Z">
                    </path>
                </svg>
            </div>

            <div class="max-w-7xl mx-auto px-4 ">
                <h2 class="text-4xl font-bold mb-12 text-center text-[#007948]">Artikel Pilihan</h2>

                <div class="relative overflow-hidden group">
                    <div id="carousel" class="flex transition-transform duration-700 ease-in-out">

                        <!-- Card Items -->
                        <div class="card bg-white border border-[#007948] shadow-md w-64 flex-shrink-0 mx-2">
                            <figure><img
                                    src="https://img.daisyui.com/images/stock/photo-1625726411847-8cbb60cc71e6.webp"
                                    class="h-40 w-full object-cover" alt="Artikel 1" /></figure>
                            <div class="card-body">
                                <h3 class="card-title text-lg text-[#007948]">Artikel 1</h3>
                                <p class="text-sm text-gray-600">Deskripsi singkat artikel ini.</p>
                            </div>
                        </div>

                        <div class="card bg-white border border-[#007948] shadow-md w-64 flex-shrink-0 mx-2">
                            <figure><img
                                    src="https://img.daisyui.com/images/stock/photo-1609621838510-5ad474b7d25d.webp"
                                    class="h-40 w-full object-cover" alt="Artikel 2" /></figure>
                            <div class="card-body">
                                <h3 class="card-title text-lg text-[#007948]">Artikel 2</h3>
                                <p class="text-sm text-gray-600">Deskripsi singkat artikel ini.</p>
                            </div>
                        </div>

                        <div class="card bg-white border border-[#007948] shadow-md w-64 flex-shrink-0 mx-2">
                            <figure><img
                                    src="https://img.daisyui.com/images/stock/photo-1414694762283-acccc27bca85.webp"
                                    class="h-40 w-full object-cover" alt="Artikel 3" /></figure>
                            <div class="card-body">
                                <h3 class="card-title text-lg text-[#007948]">Artikel 3</h3>
                                <p class="text-sm text-gray-600">Deskripsi singkat artikel ini.</p>
                            </div>
                        </div>

                        <div class="card bg-white border border-[#007948] shadow-md w-64 flex-shrink-0 mx-2">
                            <figure><img
                                    src="https://img.daisyui.com/images/stock/photo-1625726411847-8cbb60cc71e6.webp"
                                    class="h-40 w-full object-cover" alt="Artikel 1" /></figure>
                            <div class="card-body">
                                <h3 class="card-title text-lg text-[#007948]">Artikel 1</h3>
                                <p class="text-sm text-gray-600">Deskripsi singkat artikel ini.</p>
                            </div>
                        </div>

                        <div class="card bg-white border border-[#007948] shadow-md w-64 flex-shrink-0 mx-2">
                            <figure><img
                                    src="https://img.daisyui.com/images/stock/photo-1609621838510-5ad474b7d25d.webp"
                                    class="h-40 w-full object-cover" alt="Artikel 2" /></figure>
                            <div class="card-body">
                                <h3 class="card-title text-lg text-[#007948]">Artikel 2</h3>
                                <p class="text-sm text-gray-600">Deskripsi singkat artikel ini.</p>
                            </div>
                        </div>

                        <div class="card bg-white border border-[#007948] shadow-md w-64 flex-shrink-0 mx-2">
                            <figure><img
                                    src="https://img.daisyui.com/images/stock/photo-1414694762283-acccc27bca85.webp"
                                    class="h-40 w-full object-cover" alt="Artikel 3" /></figure>
                            <div class="card-body">
                                <h3 class="card-title text-lg text-[#007948]">Artikel 3</h3>
                                <p class="text-sm text-gray-600">Deskripsi singkat artikel ini.</p>
                            </div>
                        </div>

                    </div>

                    <!-- Tombol Navigasi -->
                    <div
                        class="absolute left-0 right-0 top-1/2 flex justify-between transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 px-6">
                        <button id="prevBtn"
                            class="btn btn-circle bg-[#F17025]/80 text-white shadow-lg backdrop-blur-md hover:bg-[#F17025] border-2 border-white ring-1 ring-white/50">❮</button>
                        <button id="nextBtn"
                            class="btn btn-circle bg-[#F17025]/80 text-white shadow-lg backdrop-blur-md hover:bg-[#F17025] border-2 border-white ring-1 ring-white/50">❯</button>
                    </div>

                    <!-- Dots Indicator -->
                    <div id="dots" class="flex justify-center mt-8 space-x-2 mb-4"></div>
                </div>
            </div>

            <!-- SVG Wave Bottom -->
            <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180"
                style="height: 80px;">
                <svg class="relative block w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80"
                    preserveAspectRatio="none">
                    <path fill="#bbf7d0"
                        d="M0,32L60,48C120,64,240,64,360,48C480,32,600,0,720,0C840,0,960,32,1080,53.3C1200,75,1320,85,1380,90L1440,96V0H1380C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0H0Z">
                    </path>
                </svg>
            </div>
        </section>

        <!-- Section 3 - Green -->
        <section class="relative bg-gradient-to-b from-[#007948] to-[#00643d] text-white py-24 overflow-hidden">
            <div class="absolute top-0 left-0 w-full overflow-hidden leading-none " style="height: 80px;">
                <svg class="relative block w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80"
                    preserveAspectRatio="none">
                    <path fill="#bbf7d0"
                        d="M0,32L60,48C120,64,240,64,360,48C480,32,600,0,720,0C840,0,960,32,1080,53.3C1200,75,1320,85,1380,90L1440,96V0H1380C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0H0Z">
                    </path>
                </svg>
            </div>
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-4xl font-bold mb-6 text-center">Leaderboard Highlights</h2>
                <p class="text-lg text-center mb-12">Prestasi terbaik dari peserta kami.</p>

                <div class="overflow-auto rounded-lg">
                    <table class="table-auto w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F17025] bg-opacity-40">
                                <th class="px-6 py-3 text-sm font-semibold uppercase tracking-wider">Rank</th>
                                <th class="px-6 py-3 text-sm font-semibold uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-sm font-semibold uppercase tracking-wider">Skor</th>
                                <th class="px-6 py-3 text-sm font-semibold uppercase tracking-wider">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-gray-800 rounded-lg overflow-hidden">
                            <!-- Dummy Data -->
                            <tr class="hover:bg-[#F0FDF4]">
                                <td class="px-6 py-4 font-bold text-lg">🥇</td>
                                <td class="px-6 py-4">Ahmad Fauzi</td>
                                <td class="px-6 py-4">980</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: 98%; background-color: #007445;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-green-100">
                                <td class="px-6 py-4 font-bold text-lg">🥈</td>
                                <td class="px-6 py-4">Siti Nurhaliza</td>
                                <td class="px-6 py-4">950</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: 98%; background-color: #007445;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-green-100">
                                <td class="px-6 py-4 font-bold text-lg">🥉</td>
                                <td class="px-6 py-4">Budi Santoso</td>
                                <td class="px-6 py-4">940</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: 98%; background-color: #007445;">
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Normal Rank -->
                            <tr class="hover:bg-green-100">
                                <td class="px-6 py-4 font-bold">4</td>
                                <td class="px-6 py-4">Rina Agustina</td>
                                <td class="px-6 py-4">920</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: 98%; background-color: #007445;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-green-100">
                                <td class="px-6 py-4 font-bold">5</td>
                                <td class="px-6 py-4">Fajar Maulana</td>
                                <td class="px-6 py-4">910</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: 98%; background-color: #007445;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-green-100">
                                <td class="px-6 py-4 font-bold">6</td>
                                <td class="px-6 py-4">Dewi Sartika</td>
                                <td class="px-6 py-4">905</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: 98%; background-color: #007445;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-green-100">
                                <td class="px-6 py-4 font-bold">7</td>
                                <td class="px-6 py-4">Rizky Hidayat</td>
                                <td class="px-6 py-4">890</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: 98%; background-color: #007445;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-green-100">
                                <td class="px-6 py-4 font-bold">8</td>
                                <td class="px-6 py-4">Yulia Rahma</td>
                                <td class="px-6 py-4">880</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: 98%; background-color: #007445;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-green-100">
                                <td class="px-6 py-4 font-bold">9</td>
                                <td class="px-6 py-4">Hendra Saputra</td>
                                <td class="px-6 py-4">870</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: 98%; background-color: #007445;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-green-100">
                                <td class="px-6 py-4 font-bold">10</td>
                                <td class="px-6 py-4">Lisa Adinda</td>
                                <td class="px-6 py-4">860</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: 98%; background-color: #007445;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SVG Wave Transition Bottom -->
            <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180"
                style="height: 80px;">
                <svg class="relative block w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80"
                    preserveAspectRatio="none">
                    <path fill="#bbf7d0"
                        d="M0,32L60,48C120,64,240,64,360,48C480,32,600,0,720,0C840,0,960,32,1080,53.3C1200,75,1320,85,1380,90L1440,96V0H1380C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0H0Z">
                    </path>
                </svg>
            </div>
        </section>

        <!-- Section 4 - White -->
        <section class="relative bg-gradient-to-b from-white to-green-50 text-gray-800 py-24 overflow-hidden">
            <!-- SVG Wave Top -->
            <div class="absolute top-0 left-0 w-full overflow-hidden leading-none" style="height: 80px;">
                <svg class="relative block w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80"
                    preserveAspectRatio="none">
                    <path fill="#bbf7d0"
                        d="M0,32L60,48C120,64,240,64,360,48C480,32,600,0,720,0C840,0,960,32,1080,53.3C1200,75,1320,85,1380,90L1440,96V0H1380C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0H0Z">
                    </path>
                </svg>
            </div>

            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <h2 class="text-4xl font-bold mb-6 text-[#007948]">Join Our Community</h2>
                <p class="text-lg mb-8 text-gray-700">Bergabung bersama kami dan jadi bagian dari perubahan positif!
                </p>
                <a href="#"
                    class="inline-block bg-[#F17025] hover:bg-[#e35f12] text-white font-semibold py-3 px-8 rounded-full shadow-lg transition duration-300">
                    Gabung Sekarang
                </a>
            </div>

            <!-- SVG Wave Bottom -->
            <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180"
                style="height: 80px;">
                <svg class="relative block w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80"
                    preserveAspectRatio="none">
                    <path fill="#bbf7d0"
                        d="M0,32L60,48C120,64,240,64,360,48C480,32,600,0,720,0C840,0,960,32,1080,53.3C1200,75,1320,85,1380,90L1440,96V0H1380C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0H0Z">
                    </path>
                </svg>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-[#007546] text-white py-14 relative">
        <div class="max-w-7xl mx-auto px-4 flex flex-col-reverse md:flex-row justify-between gap-10">
            <!-- Left -->
            <div class="md:w-2/3">
                <p class="text-white mb-6 leading-relaxed">
                    Bergabung bersama Sunnah Sport dan wujudkan semangat sunnah melalui olahraga berkuda, memanah, dan
                    berkegiatan aktif lainnya.
                </p>
                <p class="text-sm text-white">&copy; 2025 Sunnah Sport. All rights reserved.</p>
            </div>

            <!-- Right -->
            <div class="md:w-1/3">
                <h3 class="text-xl font-bold text-white mb-6">Hubungi Kami</h3>
                <ul class="space-y-3 text-white">
                    <li>Email: sunnahsport@email.com</li>
                    <li>Instagram: @sunnahsport.id</li>
                    <li>Phone: +62 812-3456-7890</li>
                </ul>
            </div>
        </div>
    </footer>


    <!-- Scripts -->
    <script>
        // Sticky Navbar Show/Hide + Transparent
        const navbar = document.getElementById('navbar');

        function updateNavbar() {
            if (window.scrollY > 50) {
                navbar.classList.remove('backdrop-blur-md', 'bg-[#007546]/90');
                navbar.classList.add('bg-[#007546]');
            } else {
                navbar.classList.remove('bg-[#007546]');
                navbar.classList.add('backdrop-blur-md', 'bg-[#007546]/90');
            }
        }

        // Saat pertama kali jalan
        updateNavbar();

        // Update saat scroll
        window.addEventListener('scroll', updateNavbar);


        // Dropdown Profile
        const profileButton = document.getElementById("profileButton");
        const profileMenu = document.getElementById("profileMenu");

        profileButton.addEventListener("click", function(e) {
            e.stopPropagation();
            profileMenu.classList.toggle("hidden");
        });
        document.addEventListener("click", function(e) {
            if (!profileMenu.contains(e.target) && !profileButton.contains(e.target)) {
                profileMenu.classList.add("hidden");
            }
        });

        // Mobile Menu Toggle + Hamburger Animasi
        const menuButton = document.getElementById("menu-button");
        const mobileMenu = document.getElementById("mobile-menu");
        const menuIcon = document.getElementById("menu-icon");
        const menuPath = document.getElementById("menu-path");

        menuButton.addEventListener("click", function(event) {
            event.stopPropagation(); // Supaya klik di tombol tidak dihitung sebagai "click outside"
            mobileMenu.classList.toggle("hidden");
            mobileMenu.classList.toggle("block");

            // Toggle Hamburger jadi X
            if (mobileMenu.classList.contains("block")) {
                menuPath.setAttribute("d", "M6 18L18 6M6 6l12 12"); // Icon Close
            } else {
                menuPath.setAttribute("d", "M4 6h16M4 12h16M4 18h16"); // Icon Hamburger
            }
        });

        // Jika klik di luar menu, tutup menu
        document.addEventListener("click", function(event) {
            const isClickInsideMenu = mobileMenu.contains(event.target) || menuButton.contains(event.target);

            if (!isClickInsideMenu && mobileMenu.classList.contains("block")) {
                mobileMenu.classList.add("hidden");
                mobileMenu.classList.remove("block");
                // Balikkan icon ke Hamburger
                menuPath.setAttribute("d", "M4 6h16M4 12h16M4 18h16");
            }
        });

        // caraousel
        const carousel = document.getElementById('carousel');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const dotsContainer = document.getElementById('dots');

        let cardWidth = 0;
        let totalOriginalCards = 0;
        let visibleCards = 4;
        let currentIndex = 0;
        let isAnimating = false;
        let isDragging = false;
        let startPos = 0;
        let currentTranslate = 0;
        let prevTranslate = 0;
        let animationID;
        let autoSlide;

        // Helper Functions
        function cloneCards() {
            const cards = [...carousel.children];
            totalOriginalCards = cards.length;
            const firstClones = cards.slice(0, visibleCards).map(card => card.cloneNode(true));
            const lastClones = cards.slice(-visibleCards).map(card => card.cloneNode(true));

            firstClones.forEach(card => carousel.appendChild(card));
            lastClones.reverse().forEach(card => carousel.insertBefore(card, carousel.firstChild));
        }

        function updateCardSettings() {
            if (window.innerWidth < 640) {
                visibleCards = 1;
            } else if (window.innerWidth < 1024) {
                visibleCards = 2;
            } else if (window.innerWidth < 1280) {
                visibleCards = 3;
            } else {
                visibleCards = 4;
            }

            const firstCard = carousel.querySelector('.card');
            if (firstCard) {
                const style = window.getComputedStyle(firstCard);
                const margin = parseFloat(style.marginLeft) + parseFloat(style.marginRight);
                cardWidth = firstCard.offsetWidth + margin;
            }
        }

        function updateCarousel(transition = true) {
            if (!transition) {
                carousel.style.transition = 'none';
            } else {
                carousel.style.transition = 'transform 0.7s ease-in-out';
            }
            carousel.style.transform = `translateX(-${(currentIndex + visibleCards) * cardWidth}px)`;
            updateDots();
        }

        function nextSlide() {
            if (isAnimating) return;
            isAnimating = true;
            currentIndex++;
            updateCarousel();
        }

        function prevSlide() {
            if (isAnimating) return;
            isAnimating = true;
            currentIndex--;
            updateCarousel();
        }

        function createDots() {
            dotsContainer.innerHTML = '';
            for (let i = 0; i < totalOriginalCards; i++) {
                const dot = document.createElement('div');
                dot.className = 'w-3 h-3 rounded-full bg-gray-400 transition-transform duration-300 transform';
                dot.addEventListener('click', () => {
                    currentIndex = i;
                    updateCarousel();
                });
                dotsContainer.appendChild(dot);
            }
        }

        function updateDots() {
            const dots = dotsContainer.children;
            const activeIndex = currentIndex % totalOriginalCards;
            Array.from(dots).forEach((dot, idx) => {
                if (idx === activeIndex) {
                    dot.classList.add('bg-[#F17025]', 'scale-125');
                    dot.classList.remove('bg-gray-400');
                } else {
                    dot.classList.add('bg-gray-400');
                    dot.classList.remove('bg-[#F17025]', 'scale-125');
                }
            });
        }

        function handleTransitionEnd() {
            isAnimating = false;
            if (currentIndex >= totalOriginalCards) {
                currentIndex = 0;
                updateCarousel(false);
            }
            if (currentIndex < 0) {
                currentIndex = totalOriginalCards - 1;
                updateCarousel(false);
            }
        }

        // Drag Swipe Feature
        function touchStart(index) {
            return function(event) {
                isDragging = true;
                startPos = getPositionX(event);
                animationID = requestAnimationFrame(animation);
                carousel.style.transition = 'none';
            }
        }

        function touchMove(event) {
            if (!isDragging) return;
            const currentPosition = getPositionX(event);
            currentTranslate = prevTranslate + currentPosition - startPos;
        }

        function touchEnd() {
            cancelAnimationFrame(animationID);
            isDragging = false;
            const movedBy = currentTranslate - prevTranslate;

            if (movedBy < -100) nextSlide();
            else if (movedBy > 100) prevSlide();
            else updateCarousel();

            currentTranslate = 0;
            prevTranslate = 0;
        }

        function getPositionX(event) {
            return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
        }

        function animation() {
            if (isDragging) {
                carousel.style.transform = `translateX(${currentTranslate}px)`;
                requestAnimationFrame(animation);
            }
        }

        // Auto Slide
        function startAutoSlide() {
            autoSlide = setInterval(nextSlide, 5000);
        }

        function stopAutoSlide() {
            clearInterval(autoSlide);
        }

        // Init All
        function initCarousel() {
            updateCardSettings();
            cloneCards();
            createDots();
            updateCarousel(false);
            startAutoSlide();
        }

        carousel.addEventListener('transitionend', handleTransitionEnd);
        window.addEventListener('resize', () => {
            updateCardSettings();
            updateCarousel(false);
        });

        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        carousel.addEventListener('mouseenter', stopAutoSlide);
        carousel.addEventListener('mouseleave', startAutoSlide);

        // Drag Event
        carousel.addEventListener('touchstart', touchStart(0));
        carousel.addEventListener('touchmove', touchMove);
        carousel.addEventListener('touchend', touchEnd);

        carousel.addEventListener('mousedown', touchStart(0));
        carousel.addEventListener('mousemove', touchMove);
        carousel.addEventListener('mouseup', touchEnd);
        carousel.addEventListener('mouseleave', () => {
            if (isDragging) touchEnd();
        });

        initCarousel();
    </script>

</body>

</html>
