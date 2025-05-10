@extends('layout.app')
@section('style')
    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

    {{-- reCAPTCHA --}}
    {{-- {!! NoCaptcha::renderJs() !!} --}}
@endsection
@section('content')
    <section class="bg-gradient-to-br from-green-100 via-green-200 to-green-100 py-16 min-h-screen">
        <div class="container mx-auto px-6 md:px-12 max-w-5xl bg-white text-black py-10 rounded-3xl">
            <h2 class="text-4xl font-bold text-center text-[#F17025] mb-10">Form Pengaduan</h2>

            <form method="POST" action="#" enctype="multipart/form-data" id="pengaduanForm">
                @csrf

                <div class="mb-6">
                    <label class="block font-semibold mb-2">Judul Pengaduan</label>
                    <input type="text" name="judul" class="w-full p-3 rounded border border-gray-300" required>
                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-2">Deskripsi Pengaduan</label>
                    <textarea name="deskripsi" id="deskripsi" class="w-full p-3 border border-gray-300 z-0"></textarea>
                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-2">Tentukan Lokasi Kejadian</label>
                    <div id="map" class="w-full h-80 rounded shadow mb-3 z-0"></div>
                    <button type="button" id="locateBtn"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Gunakan Lokasi Saya</button>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>

                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 font-semibold">Kabupaten</label>
                        <input type="text" value="Garut"
                            class="w-full p-3 rounded border bg-gray-100 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label class="block mb-2 font-semibold">Kecamatan</label>
                        <select name="kecamatan" class="w-full p-3 rounded border border-gray-300" required>
                            <option value="">Pilih Kecamatan</option>
                            @foreach (['Tarogong Kidul', 'Tarogong Kaler', 'Bayongbong', 'Cikajang', 'Samarang'] as $kec)
                                <option value="{{ $kec }}">{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">alamat Lengkap</label>
                    <input type="text" class="w-full p-3 rounded border">
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Upload Foto (Min. 1, Maks. 5)</label>
                    <input type="file" name="foto[]" id="fotoInput" accept="image/*" multiple required class="hidden">
                    <label for="fotoInput"
                        class="inline-block bg-blue-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-blue-600">Pilih
                        Gambar</label>
                    <small class="text-gray-600 block mt-1">Klik gambar untuk menghapusnya.</small>
                    <div id="previewContainer" class="mt-3 flex gap-3 flex-wrap"></div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Upload Video (Opsional)</label>
                    <input type="file" name="video" id="videoInput" accept="video/*" class="hidden">
                    <label for="videoInput"
                        class="inline-block bg-blue-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-blue-600">Pilih
                        Video</label>
                    <div id="videoPreview" class="mt-3"></div>
                </div>

                <div class="mb-6">
                    {{-- {!! NoCaptcha::display() !!} --}}
                </div>

                <div class="text-center">
                    <button type="button"
                        class="bg-[#F17025] text-white font-semibold px-6 py-3 rounded-full shadow-lg hover:bg-[#d95f1e]"
                        data-modal-target="#termModal">
                        Kirim Pengaduan
                    </button>
                </div>

                <div id="termModal"
                    class="fixed hidden top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center z-50">
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
                            <button type="button" class="text-gray-500 hover:underline"
                                onclick="document.getElementById('termModal').classList.add('hidden')">Batal</button>
                            <button type="button" id="submitBtn"
                                class="bg-green-600 text-white px-4 py-2 rounded disabled:opacity-50"
                                disabled>Kirim</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script>
        CKEDITOR.replace('deskripsi');

        var map = L.map('map').setView([-7.2, 107.9], 13);
        var marker;
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; CARTO'
        }).addTo(map);

        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map);
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });

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
            });
        });

        document.getElementById('agreeCheckbox').addEventListener('change', function() {
            document.getElementById('submitBtn').disabled = !this.checked;
        });

        document.querySelector('[data-modal-target]').addEventListener('click', () => {
            document.getElementById('termModal').classList.remove('hidden');
        });

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

        document.getElementById('submitBtn').addEventListener('click', function() {
            // Sinkronisasi CKEditor ke textarea
            CKEDITOR.instances.deskripsi.updateElement();

            const form = document.getElementById('pengaduanForm');
            const formData = new FormData(form);
            const jsonData = {};

            for (let [key, value] of formData.entries()) {
                if (value instanceof File) {
                    if (!jsonData[key]) {
                        jsonData[key] = value.name;
                    } else {
                        if (!Array.isArray(jsonData[key])) {
                            jsonData[key] = [jsonData[key]];
                        }
                        jsonData[key].push(value.name);
                    }
                } else {
                    jsonData[key] = value;
                }
            }

            alert("Data yang akan dikirim:\n" + JSON.stringify(jsonData, null, 2));

            // form.submit(); // uncomment jika ingin langsung kirim setelah alert
        });
    </script>
@endsection
