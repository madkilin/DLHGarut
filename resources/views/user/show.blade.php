@extends('layout.app')
@section('style')
    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
@endsection

@section('content')
    <section class="bg-gradient-to-br from-green-100 via-green-200 to-green-100 py-16 min-h-screen">
        <div class="container mx-auto px-6 md:px-12 max-w-5xl bg-white text-black py-10 rounded-3xl">
            <h2 class="text-4xl font-bold text-center text-[#F17025] mb-10">Detail Pengaduan</h2>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Status</label>
                <p class="text-red-600 text-6xl font-bold">{{ $complaint->status }}</p>
            </div>
            <div class="mb-6">
                <label class="block font-semibold mb-2">Pengirim</label>
                <p>{{ $complaint->user->name }}</p>
            </div>
            <div class="mb-6">
                <label class="block font-semibold mb-2">Judul Pengaduan</label>
                <p>{{ $complaint->title }}</p>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Deskripsi Pengaduan</label>
                <p>{!! $complaint->description !!}</p>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Lokasi Kejadian</label>
                <p>Latitude: {{ $complaint->latitude }}</p>
                <p>Longitude: {{ $complaint->longitude }}</p>
                <div id="map" class="w-full h-80 rounded shadow mb-3 z-0"></div>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Kabupaten</label>
                <p>{{ $complaint->kabupaten }}</p>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Kecamatan</label>
                <p>{{ $complaint->kecamatan }}</p>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Alamat Lengkap</label>
                <p>{{ $complaint->full_address }}</p>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Foto Pengaduan</label>
                @if ($complaint->photos && count(json_decode($complaint->photos)) > 0)
                    <div class="mt-3 flex gap-3 flex-wrap">
                        @foreach (json_decode($complaint->photos) as $photo)
                            <img src="{{ Storage::url($photo) }}" class="h-24 w-24 object-cover rounded shadow"
                                alt="Foto Pengaduan">
                        @endforeach
                    </div>
                @else
                    <p>Tidak ada foto yang di-upload.</p>
                @endif
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Video Pengaduan</label>
                @if ($complaint->video)
                    <video controls class="w-full max-w-md rounded shadow">
                        <source src="{{ Storage::url($complaint->video) }}" type="video/mp4">
                        Browser kamu tidak support penampil video.
                    </video>
                @else
                    <p>Tidak ada video yang di-upload.</p>
                @endif
            </div>

            <div class="text-center">
                <a href="{{ route('complaint.index') }}"
                    class="bg-[#F17025] text-white font-semibold px-6 py-3 rounded-full shadow-lg hover:bg-[#d95f1e]">
                    Kembali ke Daftar Pengaduan
                </a>
            </div>
        </div>
    </section>

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map
            var map = L.map('map').setView([{{ $complaint->latitude }}, {{ $complaint->longitude }}], 16);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; CARTO'
            }).addTo(map);

            // Add marker at the complaint location
            L.marker([{{ $complaint->latitude }}, {{ $complaint->longitude }}]).addTo(map);
        });
    </script>
@endsection
@endsection
