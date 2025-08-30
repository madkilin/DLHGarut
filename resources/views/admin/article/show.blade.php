@extends('layout.app')

@section('content')
    <div class="max-w-4xl mx-auto p-10 mt-10 bg-white rounded-xl shadow text-black">
        <h2 class="text-3xl font-bold mb-4">{{ $article->title }}</h2>
        <p class="text-gray-500 mb-2">Ditulis oleh: <strong>{{ $article->user->name }}</strong></p>
        @if ($article->is_read_by_admin == 1)
            <p class="text-gray-500 mb-2">Dikonfirmasi pada : <strong>{{ $article->confirmed_at }}</strong></p>
        @endif
        @if ($article->is_read_by_admin == -1)
            <p class="text-gray-500 mb-2">Alasan Penolakan :  <strong>{{ $article->alasan_penolakan }}</strong></p>
        @endif
        <img src="{{ asset('storage/' . $article->banner) }}" alt="Banner" class="w-full rounded shadow mb-6">
        @if ($article->video)
            <div class="flex justify-center">
                <video class="w-[640px] h-[360px]" controls>
                    <source src="{{ asset('storage/' . $article->video) }}" type="video/mp4">
                </video>
            </div>
        @endif
        <div class="prose max-w-none">
            {!! $article->description !!}
        </div>
    </div>
@endsection
