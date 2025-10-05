@extends('layout.app')

@section('content')
    <section class="py-16 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-3xl p-8">
            <h2 class="text-2xl font-bold text-[#F17025] mb-6">Tambah User</h2>

            <form action="{{ route('users.store') }}" method="POST" class="text-black">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold">Nama</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1"
                        required>
                </div>
                <div class="mb-4">
                    <label for="nik" class="block text-sm font-semibold">NIK</label>
                    <input type="text" name="nik" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1"
                        required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-semibold">Nomor Telepon</label>
                    <input type="text" name="phone" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1"
                        required>
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-sm font-semibold">Alamat</label>
                    <textarea name="address" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1"
                        required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold">Password</label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1"
                        required>
                </div>

                <div class="mb-4">
                    <label for="role_id" class="block text-sm font-semibold">Role</label>
                    <select name="role_id" id="role_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1"
                        required>
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('users.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-lg">Batal</a>
                    <button type="submit"
                        class="bg-[#007546] hover:bg-green-700 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
