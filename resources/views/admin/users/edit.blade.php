@extends('layout.app')

@section('content')
<section class="py-16 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-3xl p-8">
        <h2 class="text-2xl font-bold text-[#F17025] mb-6">Edit User</h2>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="text-black">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label for="nik" class="block text-sm font-semibold">NIK</label>
                <input type="text" id="nik" name="nik" value="{{ $user->nik }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-semibold">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ $user->phone }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-semibold">Alamat</label>
                <textarea name="address" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>{{ $user->address }}</textarea>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold">Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold">Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
            </div>

            <div class="mb-6 hidden">
                <label for="status" class="block text-sm font-semibold">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonactive" {{ $user->status === 'nonactive' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="belum diverifikasi" {{ $user->status === 'belum diverifikasi' ? 'selected' : '' }}>
                        Belum Diverifikasi</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('users.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-lg">Batal</a>
                <button type="submit"
                    class="bg-[#007546] hover:bg-green-700 text-white px-4 py-2 rounded-lg">Perbarui</button>
            </div>
        </form>
    </div>
</section>
@section('script')
<script>
    // Batasi panjang NIK
    document.getElementById('nik').addEventListener('input', function() {
        let val = this.value;

        // Hapus semua karakter selain angka
        val = val.replace(/\D/g, '');
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });

    // Batasi panjang Nomor Telepon
    document.getElementById('phone').addEventListener('input', function() {
        let val = this.value;

        // Hapus semua karakter selain angka
        val = val.replace(/\D/g, '');

        // Pastikan dimulai dengan "08"
        if (!val.startsWith('08')) {
            if (val.startsWith('8')) {
                val = '0' + val; // kalau user ngetik 8 di awal
            } else if (!val.startsWith('08')) {
                val = '08'; // kalau awalnya bukan 0/8, langsung ubah jadi 08
            }
        }

        // Batasi maksimal 13 digit
        if (val.length > 13) {
            val = val.slice(0, 13);
        }

        this.value = val;
    });
</script>
@endsection
@endsection