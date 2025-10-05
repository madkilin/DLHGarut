@extends('layout.app')

@section('content')
    <section class="py-16 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-3xl p-8">
            <h2 class="text-2xl font-bold text-[#F17025] mb-6">Detail User</h2>

            <div class="space-y-4">
                <div>
                    <span class="font-semibold text-gray-700">Nama:</span>
                    <p class="text-gray-900">{{ $user->name }}</p>
                </div>

                <div>
                    <span class="font-semibold text-gray-700">Email:</span>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>

                <div>
                    <span class="font-semibold text-gray-700">Status:</span>
                    <p class="text-gray-900 capitalize">{{ $user->status }}</p>
                </div>

                <div>
                    <span class="font-semibold text-gray-700">Role:</span>
                    <p class="text-gray-900">{{ $user->role?->name ?? '-' }}</p>
                </div>

                <div>
                    <span class="font-semibold text-gray-700">NIK:</span>
                    <p class="text-gray-900">{{ $user->nik ?? '-' }}</p>
                </div>

                <div>
                    <span class="font-semibold text-gray-700">Nomor Telepon:</span>
                    <p class="text-gray-900">{{ $user->phone ?? '-' }}</p>
                </div>

                <div>
                    <span class="font-semibold text-gray-700">Alamat:</span>
                    <p class="text-gray-900">{{ $user->address ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('users.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-lg">Kembali</a>
            </div>
        </div>
    </section>
@endsection
