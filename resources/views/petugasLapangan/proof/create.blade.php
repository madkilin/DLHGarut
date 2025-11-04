@extends('layout.app')

@section('content')
    <section class="py-20 min-h-screen bg-gradient-to-br from-green-100 via-green-200 to-green-100">
        <div class="py-12 px-6 sm:px-10 max-w-3xl mx-auto bg-white text-black rounded-3xl shadow-lg">
            <h2 class="text-3xl font-bold mb-8 text-center">Form Bukti Penyelesaian</h2>

            <form action="{{ route('petugas.proof.store', $complaint->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label class="block font-semibold mb-2">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-green-400 focus:outline-none" required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-2">Petugas</label>
                    <div id="officerContainer" class="space-y-2">
                        <div class="flex items-center gap-2">
                            <input type="text" name="officers[]" placeholder="Nama Petugas"
                                class="flex-1 p-2 border rounded-xl focus:ring-green-400 focus:outline-none">
                        </div>
                    </div>
                    <button type="button" id="addOfficer"
                        class="mt-3 inline-flex items-center gap-1 text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full shadow">
                        + Tambah Petugas
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block font-semibold mb-2">Jumlah Sampah</label>
                        <input type="number" name="amount"
                            class="w-full p-2 border rounded-xl focus:ring-green-400 focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-2">Satuan</label>
                        <input type="text" name="unit" placeholder="Kg / Kantong / dst"
                            class="w-full p-2 border rounded-xl focus:ring-green-400 focus:outline-none" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-2">Upload Foto (maks 5) (maks Foto: 2mb)</label>
                    <input type="file" name="photos[]" id="photoInput" accept="image/*" multiple class="hidden">
                    <label for="photoInput"
                        class="bg-green-600 text-white px-4 py-2 inline-block rounded cursor-pointer hover:bg-green-700">
                        Pilih Gambar
                    </label>
                    <small class="block text-gray-600 mt-1">Klik gambar untuk menghapus</small>
                    <div id="previewContainer" class="mt-4 flex flex-wrap gap-3"></div>
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="bg-orange-600 text-white px-6 py-3 rounded-xl text-lg font-semibold hover:bg-orange-700 shadow-lg">
                        Kirim Bukti
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const officerContainer = document.getElementById('officerContainer');

            document.getElementById('addOfficer').addEventListener('click', function() {
                const wrapper = document.createElement('div');
                wrapper.className = 'flex items-center gap-2';

                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'officers[]';
                input.placeholder = 'Nama Petugas';
                input.className = 'flex-1 p-2 border rounded-xl focus:ring-green-400 focus:outline-none';

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.innerHTML = '❌';
                removeBtn.className = 'text-red-600 hover:text-red-800 text-lg font-bold';
                removeBtn.addEventListener('click', () => wrapper.remove());

                wrapper.appendChild(input);
                wrapper.appendChild(removeBtn);

                officerContainer.appendChild(wrapper);
            });

            // Preview Foto
            const photoInput = document.getElementById('photoInput');
            const previewContainer = document.getElementById('previewContainer');
            let selectedPhotos = [];

            photoInput.addEventListener('change', function() {
                const files = Array.from(photoInput.files);
                files.forEach(file => {
                    selectedPhotos.push(file);
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className =
                            "w-24 h-24 object-cover rounded-lg cursor-pointer border-2 border-green-500";
                        img.addEventListener('click', () => {
                            selectedPhotos = selectedPhotos.filter(f => f !== file);
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
                selectedPhotos.forEach(file => dt.items.add(file));
                photoInput.files = dt.files;
            }
        });
    </script>
@endsection
