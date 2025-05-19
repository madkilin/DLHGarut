@extends('layout.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        table.dataTable,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_paginate {
            color: #000 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            margin-left: 4px;
            border-radius: 6px;
            background-color: #F17025 !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #007546 !important;
            color: white !important;
        }
    </style>
@endsection

@section('content')
    <section class="py-20 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="bg-white shadow-lg rounded-3xl p-8">
                <h2 class="text-2xl font-bold text-[#F17025] mb-6">Daftar Tugas Pengaduan Anda</h2>

                <div class="overflow-x-auto">
                    <table id="petugasTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#007546] text-white">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Tanggal</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Nama Pengadu</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Titik Koordinat</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Alamat</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($complaints as $complaint)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ $complaint->created_at->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->user->name }}</td>
                                    <td class="px-4 py-2 text-sm text-blue-600 underline">
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $complaint->latitude }},{{ $complaint->longitude }}"
                                            target="_blank">
                                            {{ $complaint->latitude }}, {{ $complaint->longitude }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">Perum Rabany Regency</td>
                                    <td class="px-4 py-2 flex gap-2">
                                        <a href="{{ route('petugas.complaints.show', $complaint->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-xs rounded-full">
                                            Detail
                                        </a>
                                        <a href="{{ route('petugas.proof.create', $complaint->id) }}"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 text-xs rounded-full">
                                            Kirim Bukti
                                        </a>
                                        <a href="{{ route('petugas.proof.show', $complaint->proof->id ?? 0) }}"
                                            class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 text-xs rounded-full">
                                            Lihat Bukti
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#petugasTable').DataTable({
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "→",
                        previous: "←"
                    },
                    zeroRecords: "Tidak ada data ditemukan",
                }
            });
        });
    </script>
@endsection
