@extends('layout.app')

@section('style')
    <script src="https://unpkg.com/feather-icons"></script>
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            position: relative;
            /* pastikan relatif, bukan absolute */
            z-index: 1;
            /* supaya nggak numpuk di atas navbar */
        }
    </style>
@endsection

@section('content')
    <section class="py-16 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 bg-white shadow-lg rounded-3xl py-8">
            <h1 class="text-3xl font-bold mb-10 text-center text-green-700">Dashboard Admin</h1>

            {{-- Widget: User Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10 text-black">
                @php
                    $userWidgets = [['label' => 'Total User', 'value' => $totalUsers, 'icon' => 'users', 'color' => 'bg-green-100', 'text' => 'text-green-600'], ['label' => 'Total Penukaran Reward', 'value' => $totalRewardHistories, 'icon' => 'award', 'color' => 'bg-blue-100', 'text' => 'text-blue-600']];
                @endphp

                @foreach ($userWidgets as $widget)
                    <div class="{{ $widget['color'] }} p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="{{ $widget['text'] }}">
                                <i data-feather="{{ $widget['icon'] }}" class="w-7 h-7"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $widget['label'] }}</p>
                                <p class="text-2xl font-bold">{{ $widget['value'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Total Masyarakat with active & nonactive --}}
                <div class="bg-yellow-100 p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="text-yellow-600">
                            <i data-feather="file" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Total Artikel</p>
                            <p class="text-2xl font-bold">{{ $totalArticles }}</p>
                        </div>
                    </div>
                    {{-- <div class="text-sm text-gray-700 ml-11">
                        <p>Aktif: <span class="font-semibold">{{ $masyarakatAktif }}</span></p>
                        <p>Nonaktif: <span class="font-semibold">{{ $masyarakatNonaktif }}</span></p>
                    </div> --}}
                </div>

                {{-- Pie Chart --}}
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300 flex justify-center items-center">
                    <canvas id="userPieChart" width="120" height="120"></canvas>
                </div>
            </div>


            {{-- Widget: Complaint Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-10 text-black">
                @php
                    $complaintWidgets = [['label' => 'Terkirim', 'key' => 'terkirim', 'icon' => 'send', 'color' => 'bg-gray-100', 'text' => 'text-gray-700'], ['label' => 'Diterima', 'key' => 'diterima', 'icon' => 'inbox', 'color' => 'bg-green-100', 'text' => 'text-green-600'], ['label' => 'Diproses', 'key' => 'diproses', 'icon' => 'loader', 'color' => 'bg-yellow-100', 'text' => 'text-yellow-600'], ['label' => 'Ditolak', 'key' => 'ditolak', 'icon' => 'x-circle', 'color' => 'bg-red-100', 'text' => 'text-red-600'], ['label' => 'Selesai', 'key' => 'selesai', 'icon' => 'check-circle', 'color' => 'bg-blue-100', 'text' => 'text-blue-600']];
                @endphp

                @foreach ($complaintWidgets as $widget)
                    <div class="{{ $widget['color'] }} p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="{{ $widget['text'] }}">
                                <i data-feather="{{ $widget['icon'] }}" class="w-7 h-7"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $widget['label'] }}</p>
                                <p class="text-2xl font-bold">{{ $complaintCounts[$widget['key']] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pie Chart --}}
            <div class="bg-white p-6 rounded-xl shadow text-black flex justify-center">
                <div class="text-center">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Distribusi Status Pengaduan</h3>
                    <canvas id="complaintPieChart" width="250" height="250"></canvas>
                </div>
            </div>

            <div class="mb-10 mt-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Peta Pengaduan</h3>
                <div id="map"></div>
            </div>
        </div>
    </section>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        feather.replace();

        // === Data koordinat dari PHP ===
        // Contoh format data yang dikirim dari controller
        // $locations = [
        //     ['lat' => -6.200000, 'lng' => 106.816666, 'label' => 'Jakarta'],
        //     ['lat' => -7.250445, 'lng' => 112.768845, 'label' => 'Surabaya']
        // ];
        const locations = @json($locations);

        // Inisialisasi peta
        const map = L.map('map').setView([-2.548926, 118.0148634], 5); // posisi awal Indonesia
        // Buat array LatLng dari semua titik
        const latlngs = locations.map(loc => [loc.lat, loc.lng]);

        // Tambahkan semua marker ke map
        latlngs.forEach((coords, i) => {
            L.marker(coords)
                .addTo(map)
                .bindPopup(`<b>${locations[i].label}</b><br>Lat: ${coords[0]}, Lng: ${coords[1]}`);
        });

        // Zoom otomatis ke semua titik
        if (latlngs.length > 0) {
            map.fitBounds(latlngs);

            // Setelah fitBounds, kurangi zoom biar agak jauh
            const currentZoom = map.getZoom();
            map.setZoom(13); // Kurangi 1 level zoom
        }
        // Tambahkan tile layer (peta dasar)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Loop untuk menambahkan marker
        locations.forEach(function(loc) {
            L.marker([loc.lat, loc.lng])
                .addTo(map)
                .bindPopup(`<b>${loc.title}</b><br>Pelapor : ${loc.label}<br> Status : ${loc.status} <br> Link : <a target="_blank" href="/admin/complaints/${loc.id}/show">Buka pengaduan</a> <br>Lat: ${loc.lat}, Lng: ${loc.lng}`);
        });

        new Chart(document.getElementById('userPieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Petugas', 'Masyarakat'],
                datasets: [{
                    data: [{{ $totalPetugas }}, {{ $totalMasyarakat }}],
                    backgroundColor: ['#3b82f6', '#facc15'],
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        new Chart(document.getElementById('complaintPieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Terkirim', 'Diterima', 'Diproses', 'Ditolak', 'Selesai'],
                datasets: [{
                    data: [
                        {{ $complaintCounts['terkirim'] }},
                        {{ $complaintCounts['diterima'] }},
                        {{ $complaintCounts['diproses'] }},
                        {{ $complaintCounts['ditolak'] }},
                        {{ $complaintCounts['selesai'] }}
                    ],
                    backgroundColor: ['#d1d5db', '#4ade80', '#facc15', '#f87171', '#60a5fa']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
@endsection
