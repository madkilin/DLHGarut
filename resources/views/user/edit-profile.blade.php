<!-- Modal Edit Profil -->
<div id="editProfileModal"
    class="fixed inset-0 bg-black bg-opacity-10 flex items-center justify-center z-50 hidden p-3 my-3">
    <div class="bg-white w-full max-w-lg rounded-xl p-6 relative shadow-lg max-h-screen overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4 text-[#F17025]">Edit Profil</h2>

        <!-- Form Edit -->
        <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
            class="text-black">
            @csrf
            <div class="mb-4">
                <label class="block text-black">Nama</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded p-2"
                    value="{{ old('name', Auth::user()->name) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-black">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded p-2"
                    value="{{ old('email', Auth::user()->email) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-black">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded p-2"
                    placeholder="Biarkan kosong jika tidak ingin mengubah password">
            </div>

            <div class="mb-4">
                <label class="block text-black">NIK</label>
                <input type="text" name="nik" class="w-full border border-gray-300 rounded p-2"
                    value="{{old('nik', Auth::user()->nik)}}" required>
            </div>
            <div class="mb-4">
                <label class="block text-black">No Telepon</label>
                <input type="text" name="phone" class="w-full border border-gray-300 rounded p-2"
                    value="{{old('phone', Auth::user()->phone)}}">
            </div>

            <div class="mb-4">
                <label class="block text-black">Alamat</label>
                <textarea name="address" class="w-full border border-gray-300 rounded p-2" rows="2"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-black">Foto Profil</label>
                <div class="flex flex-col items-center justify-center border border-gray-300 rounded p-4">
                    <!-- Preview -->
                    <img id="profileImagePreview" src="" alt="Preview"
                        class="w-24 h-24 rounded-full object-cover border mb-2 hidden" />

                    <!-- Input -->
                    <input type="file" accept="image/*" id="profileImageInput" class="text-center"
                        name="profile_photo" />
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeModal('editProfileModal')"
                    class="mr-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Batal</button>
                <button type="submit"
                    class="px-4 py-2 bg-[#F17025] text-white rounded hover:bg-orange-600 transition">Simpan</button>
            </div>
        </form>

        <!-- Close Icon -->
        <button onclick="closeModal('editProfileModal')"
            class="absolute top-2 right-4 text-gray-500 hover:text-black text-2xl">&times;</button>
    </div>
</div>