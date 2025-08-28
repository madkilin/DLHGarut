@extends('layout.app')
@section('style')
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
@endsection
@section('content')
    <section class="py-16 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
        <div class="container mx-auto px-6 md:px-12 max-w-5xl bg-white text-black py-10 rounded-3xl">
            <h2 class="text-2xl font-bold text-[#F17025] mb-6">Tambah Artikel</h2>
            <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data" class="text-black">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-semibold">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                </div>
                <div class="mb-4">
                    <label for="banner" class="block text-sm font-semibold">Banner <span class="text-red-500">*</span></label>
                    <input type="file" name="banner" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                </div>

                <div class="mb-4">
                    <label for="video" class="block text-sm font-semibold">Video</label>
                    <input type="file" name="video" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" >
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-semibold">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" class="w-full p-3 border border-gray-300 z-0"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-lg">Batal</a>
                    <button type="submit" class="bg-[#007546] hover:bg-green-700 text-white px-4 py-2 rounded-lg pointer">Simpan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('description');
        });
    </script>
@endsection
