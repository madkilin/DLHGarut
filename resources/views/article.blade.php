@extends('layout.app')
@section('content')
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
@endsection