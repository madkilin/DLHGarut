@extends('layout.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 mt-10 rounded-xl shadow text-black">
    <h2 class="text-2xl font-bold mb-6">Edit Artikel</h2>

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium">Judul</label>
            <input type="text" name="title" class="w-full border px-4 py-2 rounded" value="{{ $article->title }}"
                required>
        </div>



        <div class="mb-4">
            <label class="block mb-1 font-medium">Banner (dengan maks Foto: 2mb)</label>
            <input type="file" name="banner" id="banner" class="w-full border px-4 py-2 rounded" accept="image/*"
                onchange="previewBanner(event)">
            <img id="bannerPreview" src="{{ asset('storage/' . $article->banner) }}"
                class="mt-3 max-h-48 rounded shadow" />
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea name="description" id="description" rows="10" class="w-full border rounded">{{ $article->description }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Update</button>
    </form>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');

    function previewBanner(event) {
        const input = event.target;
        const preview = document.getElementById('bannerPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection