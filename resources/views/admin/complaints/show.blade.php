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
    <div
        class="container mx-auto px-6 md:px-12 max-w-5xl bg-white text-black py-10 rounded-3xl shadow-xl border space-y-6">
        <h2 class="text-4xl font-bold text-center text-[#F17025] mb-10">Detail Pengaduan</h2>

        <div class="space-y-2">
            <label class="block font-semibold mb-2">Status</label>
            <p class="text-red-600 text-6xl font-bold">{{ $complaint->status }}</p>

            @if ($complaint->status == 'ditolak')
            <label class="block font-semibold mb-2">Alasan penolakan</label>
            <p class="text-red-600 font-bold">{{ $complaint->note }}</p>
            @endif


        </div>
        <div class="space-y-2">
            <label class="block font-semibold mb-2">tanggal pengaduan</label>
            <p>{{ \Carbon\Carbon::parse($complaint->created_at)->locale('id')->translatedFormat('d F Y') }}</p>
            <br>
            <label class="block font-semibold mb-2">tanggal Penyelesaian</label>
            <p>
            <p>
                @if ($complaint->created_at != $complaint->updated_at && $complaint->status == 'selesai')
                {{ \Carbon\Carbon::parse($complaint->updated_at)->locale('id')->translatedFormat('d F Y') }}
                @else
                -
                @endif
            </p>
            </p>

        </div>

        <div class="space-y-2">
            <label class="block font-semibold mb-2">Pengirim</label>
            <ul class="list-disc list-inside text-gray-700">
                <li><strong>Nama:</strong> {{ $complaint->user->name }}</li>
                <li><strong>NIK:</strong> {{ $complaint->user->nik }}</li>
                <li><strong>Telepon:</strong> {{ $complaint->user->phone }}</li>
                <li><strong>Email:</strong> {{ $complaint->user->email }}</li>
            </ul>
        </div>
        <div class="space-y-2">
            <label class="block font-semibold mb-2">Judul Pengaduan</label>
            <p>{{ $complaint->title }}</p>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold mb-2">Deskripsi Pengaduan</label>
            <p>{!! $complaint->description !!}</p>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold mb-2">Lokasi Kejadian</label>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $complaint->latitude }},{{ $complaint->longitude }}"
                target="_blank" class=" text-blue-600 underline">
                {{ $complaint->latitude }}, {{ $complaint->longitude }}
            </a>
            <div id="map" class="w-full h-80 rounded shadow mb-3 z-0"></div>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold mb-2">Kabupaten</label>
            <p>{{ $complaint->kabupaten }}</p>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold mb-2">Kecamatan</label>
            <p>{{ $complaint->kecamatan }}</p>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold mb-2">Alamat Lengkap</label>
            <p>{{ $complaint->full_address }}</p>
        </div>

        <div class="space-y-2">
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

        <div class="space-y-2">
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

        <div class="text-center mt-6 flex justify-center gap-4">
            <a href="{{ route('admin.complaints.index') }}"
                class="bg-[#F17025] text-white font-semibold px-6 py-3 rounded-full shadow-lg hover:bg-[#d95f1e]">
                Kembali ke Daftar Pengaduan
            </a>
            <button onclick="window.open('{{ route('admin.complaints.print', $complaint->id) }}','_blank')"
                class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-full shadow-lg hover:bg-blue-700">
                Print Surat
            </button>
        </div>
    </div>
</section>

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil koordinat dari Blade
        var lat = {
            {
                $complaint - > latitude ?? 0
            }
        };
        var lng = {
            {
                $complaint - > longitude ?? 0
            }
        };

        // Initialize map
        var map = L.map('map').setView([lat, lng], 16);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> &copy; <a href="https://carto.com/">CARTO</a>'
        }).addTo(map);

        // Add marker
        L.marker([lat, lng]).addTo(map)
            .bindPopup("<b>Lokasi Pengaduan</b><br>{{ $complaint->full_address }}")
            .openPopup();
    });
</script>
@endsection
@endsection