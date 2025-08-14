@extends('layout.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 mt-10 rounded-xl shadow text-black">
        <h2 class="text-2xl font-bold mb-6">Tambah Artikel</h2>

        <form action="{{ route('petugas.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">Judul</label>
                <input type="text" name="title" class="w-full border px-4 py-2 rounded" required>
            </div>

            {{-- @if (auth()->user()->role_id == 1)
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Penulis</label>
                    <select name="user_id" class="w-full border px-4 py-2 rounded" required>
                        <option value="">Pilih User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif --}}

            <div class="mb-4">
                <label class="block mb-1 font-medium">Banner (minimal 800x400)</label>
                <input type="file" name="banner" id="banner" class="w-full border px-4 py-2 rounded" accept="image/*"
                    required onchange="previewBanner(event)">
                <img id="bannerPreview" class="mt-3 max-h-48 hidden rounded shadow" />
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Deskripsi</label>
                <textarea name="description" id="description" rows="10" class="w-full border rounded"></textarea>
            </div>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Simpan</button>
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
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
