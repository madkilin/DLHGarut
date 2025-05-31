@extends('layout.app')

@section('content')
    <div class="max-w-4xl mx-auto p-10 mt-10 bg-white rounded-xl shadow text-black">
        <h2 class="text-3xl font-bold mb-4">{{ $article->title }}</h2>
        <p class="text-gray-500 mb-2">Ditulis oleh: <strong>{{ $article->user->name }}</strong></p>
        <img src="{{ asset('storage/' . $article->banner) }}" alt="Banner" class="w-full rounded shadow mb-6">
        <div class="prose max-w-none">
            {!! $article->description !!}
        </div>
    </div>
@endsection
