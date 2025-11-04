@extends('layout.app')
@section('style')
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
@endsection
@section('content')
    <section class="py-16 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
        <div class="container mx-auto px-6 md:px-12 max-w-5xl bg-white text-black py-10 rounded-3xl">
            <h2 class="text-2xl font-bold text-[#F17025] mb-6">Edit Hadiah</h2>
            <form action="{{ route('reward.update', $reward->id) }}" method="POST" enctype="multipart/form-data" class="text-black">
                @method('put')
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold">Nama Hadiah</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" value="{{ $reward->name }}" required>
                    @error('name')
                        <div class="text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="banner" class="block text-sm font-semibold">Banner (dengan maks Foto: 2mb)</label>
                    <input type="file" name="banner" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                    @error('banner')
                        <div class="text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="quota" class="block text-sm font-semibold">Quota</label>
                    <input type="number" name="quota" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" value="{{ $reward->quota }}" required>
                    @error('quota')
                        <div class="text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="minimum" class="block text-sm font-semibold">Minimum Point</label>
                    <input type="number" name="minimum" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1"  value="{{ $reward->point }}" required>
                    @error('minimum')
                        <div class="text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('reward.index') }}" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-lg">Batal</a>
                    <button type="submit" class="bg-[#007546] hover:bg-green-700 text-white px-4 py-2 rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </section>
@endsection
