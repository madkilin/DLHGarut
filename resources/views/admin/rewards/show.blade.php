@extends('layout.app')
@section('content')
    <div class="max-w-4xl mx-auto p-10 mt-10 mb-10 bg-white rounded-xl shadow text-black">
        <h2 class="text-3xl font-bold mb-4">{{ $reward->name }}</h2>
        <img src="{{ asset('storage/' . $reward->image) }}" alt="Banner" class="w-full rounded shadow mb-6">
        <div class="prose max-w-none">
            <h6>Minimum Poin : {{ $reward->point }}</h6>
            <h6>Quota : {{ $reward->quota }}</h6>
        </div>
    </div>
@endsection
