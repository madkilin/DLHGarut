@extends('layout.app')
@section('title', 'Tambah Pengaduan')
@section('style')
{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-pip/leaflet-pip.min.js"></script>


{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

{{-- reCAPTCHA --}}
{{-- {!! NoCaptcha::renderJs() !!} --}}
@endsection

@section('content')
<section class="bg-gradient-to-br from-green-100 via-green-200 to-green-100 py-16 min-h-screen">
    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-4xl mx-auto mt-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-4xl mx-auto mt-4" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    <div class="container mx-auto px-6 md:px-12 max-w-5xl bg-white text-black py-10 rounded-3xl">
        <h2 class="text-4xl font-bold text-center text-[#F17025] mb-10">Form Pengaduan</h2>

        <form method="POST" action="{{ route('complaint.store') }}" enctype="multipart/form-data" id="pengaduanForm">
            @csrf

            <div class="mb-6">
                <label class="block font-semibold mb-2">Judul Pengaduan</label>
                <input type="text" name="title" class="w-full p-3 rounded border border-gray-300" required>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Deskripsi Pengaduan</label>
                <textarea name="description" id="description" class="w-full p-3 border border-gray-300 z-0"></textarea>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Tentukan Lokasi Kejadian</label>
                <div id="map" class="w-full h-80 rounded shadow mb-3 z-0"></div>
                <p id="koordinatText" class="text-sm text-gray-700 italic mb-3"></p>

                <button type="button" id="locateBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Gunakan Lokasi Saya</button>

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
            </div>

            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block mb-2 font-semibold">Kabupaten</label>
                    <input type="text" name="kabupaten" value="Garut" class="w-full p-3 rounded border bg-gray-100 cursor-not-allowed" disabled>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Kecamatan</label>
                    <select name="kecamatan" class="w-full p-3 rounded border border-gray-300" required>
                        <option value="">Pilih Kecamatan</option>
                        <option value="Garut Kota">Garut Kota</option>
                        <option value="Tarogong Kidul">Tarogong Kidul</option>
                        <option value="Tarogong Kaler">Tarogong Kaler</option>
                        <option value="Karangpawitan">Karangpawitan</option>
                        <option value="Banyuresmi">Banyuresmi</option>
                        <option value="Cilawu">Cilawu</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Desa</label>
                    <input type="text" name="desa" class="w-full p-3 rounded border">

                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Alamat Lengkap</label>
                <input type="text" name="full_address" class="w-full p-3 rounded border">
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Upload Foto (Min. 1, Maks. 5) (dengan maks Foto: 2mb)</label>
                <input type="file" name="photos[]" id="fotoInput" accept="image/*" multiple required class="hidden">
                <label for="fotoInput" class="inline-block bg-blue-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-blue-600">Pilih
                    Gambar</label>
                <small class="text-gray-600 block mt-1">Klik gambar untuk menghapusnya.</small>
                <div id="previewContainer" class="mt-3 flex gap-3 flex-wrap"></div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Upload Video (Opsional) (dengan maks Video: 10mb)</label>
                <input type="file" name="video" id="videoInput" accept="video/*" class="hidden">
                <label for="videoInput" class="inline-block bg-blue-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-blue-600">Pilih
                    Video</label>
                <div id="videoPreview" class="mt-3"></div>
            </div>

            <div class="mb-6">
                {{-- {!! NoCaptcha::display() !!} --}}
            </div>

            <div class="text-center">
                <button type="button" class="bg-[#F17025] text-white font-semibold px-6 py-3 rounded-full shadow-lg hover:bg-[#d95f1e]" data-modal-target="#termModal">
                    Kirim Pengaduan
                </button>
            </div>

            <div id="termModal" class="fixed hidden top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-lg w-full">
                    <h3 class="text-lg font-bold mb-4 text-red-600">PERHATIAN!</h3>
                    <p class="text-sm mb-4">
                        Berdasarkan Undang-Undang ITE Pasal 27 dan 28, menyampaikan informasi palsu dapat dikenakan
                        sanksi hukum. Pastikan semua informasi yang Anda berikan adalah benar dan dapat
                        dipertanggungjawabkan.
                    </p>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="agreeCheckbox" class="form-checkbox">
                        <span>Saya telah membaca dan menyetujui pernyataan di atas.</span>
                    </label>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" class="text-gray-500 hover:underline" onclick="document.getElementById('termModal').classList.add('hidden')">Batal</button>
                        <button type="button" id="submitBtn" class="bg-green-600 text-white px-4 py-2 rounded disabled:opacity-50" disabled>Kirim</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize CKEditor
        CKEDITOR.replace('description');

        // Initialize map
        var map = L.map('map').setView([-7.2, 107.9], 13);
        var marker;
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; CARTO'
        }).addTo(map);

        // Ambil data GeoJSON Garut Kota
        const geojsonFiles = [{
                name: "Garut Kota",
                url: "{{ asset('geojson/garut_kota.geojson') }}",
                color: "#F54927"
            },
            {
                name: "Tarogong Kidul",
                url: "{{ asset('geojson/tarogong_kidul.geojson') }}",
                color: "#F5BB27"
            },
            {
                name: "Tarogong Kaler",
                url: "{{ asset('geojson/tarogong_kaler.geojson') }}",
                color: "#27F554"
            },
            {
                name: "Banyuresmi",
                url: "{{ asset('geojson/banyuresmi.geojson') }}",
                color: "#27F5CC"
            },
            {
                name: "Cilawu",
                url: "{{ asset('geojson/cilawu.geojson') }}",
                color: "#D327F5"
            },
            {
                name: "Karangpawitan",
                url: "{{ asset('geojson/karangpawitan.geojson') }}",
                color: "#F52791"
            }
        ];

        let kecamatanLayers = {}; // cache semua layer
        let mapLayerGroup = L.layerGroup().addTo(map); // group untuk semua layer

        // load semua GeoJSON dan tampilkan dengan warna masing-masing
        geojsonFiles.forEach(async item => {
            const res = await fetch(item.url);
            const data = await res.json();

            const layer = L.geoJSON(data, {
                style: {
                    color: item.color, // border warna hitam
                    weight: 1,
                    fillColor:"#FFFFFF",
                    fillOpacity: 0.2
                },
                onEachFeature: function(feature, layer) {
                    const props = feature.properties;
                    const nama = props.KECAMATAN || props.Kecamatan || props.kecamatan || "Tidak diketahui";
                    layer.bindTooltip(nama, {
                        direction: "top"
                    });
                }
            });

            kecamatanLayers[item.name] = layer;
            layer.addTo(mapLayerGroup); // tampilkan semua di peta
        });

        // fungsi update select berdasarkan koordinat
        function updateKecamatanByCoords(lat, lng) {
            const kecamatanSelect = document.querySelector('select[name="kecamatan"]');
            let found = false;

            for (const key in kecamatanLayers) {
                const layer = kecamatanLayers[key];
                if (!layer) continue;

                const inside = leafletPip.pointInLayer([lng, lat], layer);

                if (inside && inside.length > 0) {
                    const props = inside[0].feature.properties;
                    const namaKecamatan = (props.KECAMATAN || props.Kecamatan || props.kecamatan || key).trim();

                    // pilih di select
                    Array.from(kecamatanSelect.options).forEach(opt => {
                        if (opt.value.trim().toLowerCase() === namaKecamatan.toLowerCase()) {
                            kecamatanSelect.value = opt.value;
                            found = true;
                        }
                    });

                    break; // berhenti setelah ketemu
                }
            }

            if (!found) {
                console.log("⚠️ Koordinat di luar area semua GeoJSON");
                kecamatanSelect.value = '';
            }

            if (found) {
                kecamatanSelect.classList.add('bg-green-100', 'transition');
                setTimeout(() => kecamatanSelect.classList.remove('bg-green-100'), 1000);
            }
        }


        // Klik di peta
        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;
            console.log("Klik di:", lat, lng);

            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            // tampilkan koordinat di bawah peta
            const text = document.getElementById('koordinatText');
            if (text) {
                text.textContent = `Koordinat dipilih: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            } else {
                console.warn('Elemen koordinatText tidak ditemukan');
            }
            updateKecamatanByCoords(lat, lng);
        });

        // Tombol "Gunakan Lokasi"
        document.getElementById('locateBtn').addEventListener('click', () => {
            if (!navigator.geolocation) return alert("Geolocation tidak didukung browser Anda.");
            navigator.geolocation.getCurrentPosition(pos => {
                const {
                    latitude,
                    longitude
                } = pos.coords;
                map.setView([latitude, longitude], 16);
                if (marker) map.removeLayer(marker);
                marker = L.marker([latitude, longitude]).addTo(map);

                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
                // Tampilkan koordinat di bawah peta
                const koordinatText = document.getElementById('koordinatText');
                if (koordinatText) {
                    koordinatText.textContent = `Koordinat Anda: ${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;
                }
                updateKecamatanByCoords(latitude, longitude); // isi otomatis kecamatan

            }, err => {
                alert("Gagal mendapatkan lokasi: " + err.message);
            });

        });
        // Agree checkbox change event
        document.getElementById('agreeCheckbox').addEventListener('change', function() {
            document.getElementById('submitBtn').disabled = !this.checked;
        });

        // Modal button click event
        const modalTarget = document.querySelector('[data-modal-target]');
        if (modalTarget) {
            modalTarget.addEventListener('click', () => {
                document.getElementById('termModal').classList.remove('hidden');
            });
        }

        // Foto preview dan hapus
        const fotoInput = document.getElementById('fotoInput');
        const previewContainer = document.getElementById('previewContainer');
        let storedFiles = [];

        fotoInput.addEventListener('change', function() {
            const files = Array.from(fotoInput.files);

            files.forEach(file => {
                if (!file.type.startsWith('image/')) return;

                storedFiles.push(file);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = "h-24 w-24 object-cover rounded shadow cursor-pointer";
                    img.title = "Klik untuk menghapus";

                    img.addEventListener('click', () => {
                        const index = storedFiles.indexOf(file);
                        if (index > -1) storedFiles.splice(index, 1);
                        updateInputFiles();
                        img.remove();
                    });

                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });

            updateInputFiles();
        });

        function updateInputFiles() {
            const dt = new DataTransfer();
            storedFiles.forEach(file => dt.items.add(file));
            fotoInput.files = dt.files;
        }

        const videoInput = document.getElementById('videoInput');
        const videoPreview = document.getElementById('videoPreview');

        videoInput.addEventListener('change', function() {
            const file = videoInput.files[0];
            videoPreview.innerHTML = ''; // Clear previous preview
            if (file && file.type.startsWith('video/')) {
                const video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.controls = true;
                video.className = "w-full max-w-md rounded shadow";
                videoPreview.appendChild(video);
            }
        });

        // Handle form submission
        document.getElementById('submitBtn').addEventListener('click', function() {
            if (document.getElementById('agreeCheckbox').checked) {
                document.getElementById('pengaduanForm').submit();
            }
        });
    });
</script>
@endsection