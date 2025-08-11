@extends('layout.app')
@section('content')
<section id="artikel" class="relative bg-gradient-to-br from-white via-green-50 to-white py-24 overflow-hidden">
    <div class="container mx-auto px-6 md:px-16">
<div class="mb-10">
    <form method="GET" class="flex flex-col sm:flex-row gap-4 justify-center items-center">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel atau penulis..."
        class="px-4 py-2 text-black rounded-xl border border-gray-300 w-full sm:w-1/2 focus:outline-none focus:ring-2 focus:ring-[#007546]">

    <button type="submit" class="px-6 py-2 bg-[#007546] text-white rounded-xl hover:bg-green-700 transition">
        Cari
    </button>
</form>
</div>
        @if($isFirstPage)
        @if($articles->count() > 0)

        <!-- Highlight Artikel -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-[#007546] mb-4">Artikel Terbaru</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Dapatkan informasi terkini dan bermanfaat seputar lingkungan, pengelolaan sampah, dan kegiatan DLH Garut.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-20">
            @foreach ($highlightArticles as $item)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition hover:shadow-2xl hover:scale-[1.01] duration-300">
                <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-[#007546] mb-2">{{ $item->title }}</h3>
                    <p class="text-sm text-gray-500 mb-1">Oleh {{ $item->user->name }}</p>


                    <p class="text-gray-700 text-sm mb-4">{{ Str::limit($item->description, 100) }}</p>
                    <a href="{{ route('artikel.show', $item->slug) }}" class="text-[#F17025] font-semibold hover:underline">Baca Selengkapnya →</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
@endif
        @endif

        @if($articles->count() > 0)

<!-- Semua Artikel -->
<div class="text-center mb-10">
    <h3 class="text-3xl font-bold text-[#007546] mb-4">Artikel</h3>
    <p class="text-gray-600 max-w-xl mx-auto">Telusuri seluruh artikel kami untuk memperluas wawasan Anda.</p>
</div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($articles as $item)
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition hover:shadow-lg hover:scale-[1.01] duration-300">
                <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->title }}" class="w-full h-36 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-semibold text-[#007546] mb-1">{{ $item->title }}</h4>
                    <p class="text-sm text-gray-500 mb-1">Oleh {{ $item->user->name }}</p>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($item->description, 80) }}</p>
                    <a href="{{ route('artikel.show', $item->slug) }}" class="text-[#F17025] text-sm font-semibold hover:underline">Baca Selengkapnya →</a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="py-15">
        <p class="text-center text-gray-500 text-lg font-medium">Maaf, artikel dengan judul atau penulis yang Anda cari tidak ditemukan.</p>
    </div>
@endif


        <div class="mt-10 flex justify-center">
    @if ($articles->hasPages())
        <nav class="inline-flex shadow-sm rounded-lg overflow-hidden" role="navigation">
            {{-- Previous Page Link --}}
            @if ($articles->onFirstPage())
                <span class="px-4 py-2 text-gray-400 bg-white border border-gray-200 cursor-default">«</span>
            @else
                <a href="{{ $articles->previousPageUrl() }}" class="px-4 py-2 text-[#007546] hover:bg-green-50 border border-gray-200">«</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                @if ($page == $articles->currentPage())
                    <span class="px-4 py-2 bg-[#007546] text-white border border-gray-200 font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-4 py-2 text-[#007546] hover:bg-green-50 border border-gray-200">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($articles->hasMorePages())
                <a href="{{ $articles->nextPageUrl() }}" class="px-4 py-2 text-[#007546] hover:bg-green-50 border border-gray-200">»</a>
            @else
                <span class="px-4 py-2 text-gray-400 bg-white border border-gray-200 cursor-default">»</span>
            @endif
        </nav>
    @endif
</div>
    </div>
</section>
@endsection
