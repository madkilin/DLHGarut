@extends('layout.app')

@section('content')
    <section class="py-20 min-h-screen bg-gradient-to-br from-green-100 via-green-200 to-green-100">
        <div class="py-12 px-6 sm:px-10 max-w-4xl mx-auto bg-white text-black rounded-3xl shadow-lg">
            <h2 class="text-3xl font-bold mb-6 text-center text-[#F17025]">Detail Bukti Penyelesaian</h2>

            <div class="mb-6">
                <p><strong>Nama Pengadu:</strong> {{ $proof->complaint->user->name }}</p>
                <p><strong>Tanggal Pengaduan:</strong> {{ $proof->complaint->created_at->format('d-m-Y') }}</p>
                <p><strong>Deskripsi:</strong> {{ $proof->description }}</p>
                <p><strong>Jumlah Sampah:</strong> {{ $proof->amount }} {{ $proof->unit }}</p>
            </div>

            @if (!empty($proof->officers))
                <div class="mb-6">
                    <h4 class="font-semibold mb-2">Petugas Tambahan:</h4>
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach ($proof->officers as $officer)
                            <li>{{ $officer }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!empty($proof->photos))
                <div class="mb-6">
                    <h4 class="font-semibold mb-2">Foto Bukti:</h4>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($proof->photos as $photo)
                            <img src="{{ asset('storage/' . $photo) }}" alt="Bukti"
                                class="w-32 h-32 object-cover rounded-xl shadow">
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="text-center mt-8">
                <a href="{{ route('petugas.complaints.index') }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl text-lg font-semibold hover:bg-blue-700 shadow-lg">
                    Kembali ke Daftar Tugas
                </a>
            </div>
        </div>
    </section>
@endsection
