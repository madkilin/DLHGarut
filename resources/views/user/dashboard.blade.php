@extends('layout.app')
@section('style')
<script src="https://unpkg.com/feather-icons"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map {
        height: 400px;
        width: 100%;
        position: relative;
        z-index: 1;
    }
</style>
@endsection

@section('content')
<section class="py-16 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 bg-white shadow-lg rounded-3xl py-8">
        <h1 class="text-3xl font-bold mb-10 text-center text-green-700">Dashboard Masyarakat</h1>
        {{-- Widget Ringkas --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10 text-black">
            @php
            $widgets = [
            ['label' => 'Total Laporan', 'key' => 'total', 'icon' => 'folder', 'color' => 'bg-blue-100', 'text' => 'text-blue-600'],
            ['label' => 'Sedang Diproses', 'key' => 'diproses', 'icon' => 'loader', 'color' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
            ['label' => 'Laporan Selesai', 'key' => 'selesai', 'icon' => 'check-circle', 'color' => 'bg-green-100', 'text' => 'text-green-600'],
            ];

            @endphp

            @foreach ($widgets as $widget)
            <div class="{{ $widget['color'] }} p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="{{ $widget['text'] }}">
                        <i data-feather="{{ $widget['icon'] }}" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ $widget['label'] }}</p>
                        <p class="text-2xl font-bold">{{ $complaintCounts[$widget['key']] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Widget Tambahan: Artikel --}}
            <div class="bg-purple-100 p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="text-purple-600">
                        <i data-feather="book-open" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Total Artikel</p>
                        <p class="text-2xl font-bold">{{ $complaintCounts['artikel'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Peta Pengaduan --}}
        <div class="mb-10 mt-5">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Peta Pengaduan</h3>
            <div id="map"></div>
        </div>



    </div>
</section>

{{-- Script --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- MAP ---
    const locations = @json($locations);
    const map = L.map('map').setView([-7.2, 107.9], 10); // Garut default

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
    }).addTo(map);

    const latlngs = locations.map(loc => [loc.lat, loc.lng]);
    latlngs.forEach((coords, i) => {
        L.marker(coords)
            .addTo(map)
            .bindPopup(`<b>${locations[i].title}</b><br>Status: ${locations[i].status}<br>Pelapor: ${locations[i].label}`);
    });

    if (latlngs.length > 0) map.fitBounds(latlngs);

    feather.replace();
</script>
@endsection