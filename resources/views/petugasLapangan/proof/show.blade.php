@extends('layout.app')
@section('style')
{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
@endsection
@section('content')
<section class="py-20 min-h-screen bg-gradient-to-br from-green-100 via-green-200 to-green-100">
    <div class="py-12 px-6 sm:px-10 max-w-4xl mx-auto bg-white text-black rounded-3xl shadow-lg">
        <h2 class="text-3xl font-bold mb-6 text-center text-[#F17025]">Detail Bukti Penyelesaian</h2>
        <div class="space-y-2">
            <label class="block font-semibold mb-2">Pengadu</label>
            <ul class="list-disc list-inside text-gray-700">
                <li><strong>Nama:</strong> {{ $proof->complaint->user->name }}</li>
                <li><strong>Telepon:</strong> {{ $proof->complaint->user->phone }}</li>
            </ul>
        </div>
        <br>

        <div class="space-y-2">
            <label class="block font-semibold mb-2">Lokasi Pelaporan</label>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $proof->complaint->latitude }},{{ $proof->complaint->longitude }}"
                target="_blank" class=" text-blue-600 underline">
                {{ $proof->complaint->latitude }}, {{ $proof->complaint->longitude }}
            </a>
                    <p>{{ $proof->complaint->kabupaten }}, {{ $proof->complaint->kecamatan }}</p>
        <p>{{ $proof->complaint->full_address }}</p>
            <div id="map" class="w-full h-80 rounded shadow mb-3 z-0"></div>
        </div>
        <div class="mb-6">
            <p><strong>Tanggal Pengaduan:</strong> {{ $proof->complaint->created_at->format('d-m-Y') }}</p>
            <p><strong>Tanggal Penyelesaian:</strong> {{ $proof->complaint->updated_at->format('d-m-Y') }}</p>
            <br>
            <p><strong>Deskripsi Penyelesaian:</strong> {{ $proof->description }}</p>
            <br>
            <p><strong>Jumlah Sampah:</strong> {{ $proof->amount }} {{ $proof->unit }}</p>
        </div>

        @if (!empty($proof->officers))
        <div class="mb-6">
            <h4 class="font-semibold mb-2">Petugas:</h4>
            <ul class="list-disc list-inside text-gray-700">
                @foreach ($proof->officers as $officer)
                <li>{{ $officer }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (!empty($proof->photos))
        <div class="mb-6">
            <h4 class="font-semibold mb-2">Foto Bukti:</h4>
            <div class="flex flex-wrap gap-4">
                @foreach ($proof->photos as $photo)
                <img src="{{ asset('storage/' . $photo) }}" alt="Bukti"
                    class="w-32 h-32 object-cover rounded-xl shadow">
                @endforeach
            </div>
        </div>
        @endif

        <div class="text-center mt-8">
            <a href="{{ route('petugas.complaints.index') }}"
                class="bg-blue-600 text-white px-6 py-3 rounded-xl text-lg font-semibold hover:bg-blue-700 shadow-lg">
                Kembali ke Daftar Pengaduan
            </a>
        </div>
    </div>
</section>
@section('script')
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil koordinat dari Blade
        var lat = {{ $proof->complaint->latitude ?? 0 }};
        var lng = {{ $proof->complaint->longitude ?? 0 }};

        // Initialize map
        var map = L.map('map').setView([lat, lng], 16);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> &copy; <a href="https://carto.com/">CARTO</a>'
        }).addTo(map);

        // Add marker
        L.marker([lat, lng]).addTo(map)
            .bindPopup("<b>Lokasi Pengaduan</b><br>{{ $proof->complaint->full_address }}")
            .openPopup();
    });
</script>
@endsection
@endsection
@endsection