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
            <div class="mb-10 mt-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Peta Pengaduan</h3>
                <div id="map"></div>
            </div>
        </div>
    </section>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
        const locations = @json($locations);
        const map = L.map('map').setView([-2.548926, 118.0148634], 5);
        const latlngs = locations.map(loc => [loc.lat, loc.lng]);

        latlngs.forEach((coords, i) => {
            L.marker(coords)
                .addTo(map)
                .bindPopup(`<b>${locations[i].label}</b><br>Lat: ${coords[0]}, Lng: ${coords[1]}`);
        });

        if (latlngs.length > 0) {
            map.fitBounds(latlngs);

            const currentZoom = map.getZoom();
            map.setZoom(13);
        }
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(map);

        locations.forEach(function(loc) {
            L.marker([loc.lat, loc.lng])
                .addTo(map)
                .bindPopup(`<b>${loc.title}</b> <br>Lat: ${loc.lat}, Lng: ${loc.lng}`);
        });
    </script>
@endsection
