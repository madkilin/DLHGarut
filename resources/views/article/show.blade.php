@extends('layout.app')

@section('content')
<section class="py-20 px-4 md:px-20 bg-white text-gray-800">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-bold text-[#007546] mb-6">{{ $article->title }}</h1>

        <img src="{{ asset($article->banner) }}" alt="{{ $article->title }}" class="w-full h-80 object-cover rounded-xl shadow mb-8">

        <p class="text-gray-700 text-base leading-relaxed whitespace-pre-line">
            {{ $article->description }}
        </p>

        <div class="mt-12">
            <a href="{{ route('artikel.index') }}" class="inline-block text-sm text-[#F17025] font-semibold hover:underline">
                ← Kembali ke Daftar Artikel
            </a>
        </div>
    </div>
</section>
@endsection
