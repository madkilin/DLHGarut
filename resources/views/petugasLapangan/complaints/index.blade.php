@extends('layout.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <style>
        body,
        table.dataTable,
        table.dataTable td,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_paginate {
            color: #1a202c !important;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            /* kecilkan font secara global */
        }

        /* Table */
        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0 6px !important;
            /* spasi antar baris lebih kecil */
        }

        table.dataTable thead th {
            background-color: #22c55e;
            color: white !important;
            font-weight: 600;
            border-radius: 6px 6px 0 0;
            padding: 8px 12px !important;
            /* padding dikurangi */
            font-size: 0.85rem;
        }

        table.dataTable tbody tr {
            background-color: #ecfdf5;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgb(34 197 94 / 0.15);
            transition: background-color 0.3s ease;
        }

        table.dataTable tbody tr:hover {
            background-color: #bbf7d0;
            box-shadow: 0 3px 8px rgb(34 197 94 / 0.25);
        }

        table.dataTable tbody td {
            padding: 8px 12px !important;
            /* padding dikurangi */
            vertical-align: middle;
            border: none !important;
            font-size: 0.85rem;
        }

        /* Pagination Buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 10px;
            margin-left: 4px;
            border-radius: 8px;
            background-color: #10b981 !important;
            color: white !important;
            font-weight: 600;
            font-size: 0.85rem;
            transition: background-color 0.3s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #047857 !important;
            color: white !important;
            box-shadow: 0 0 6px #047857;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
            background-color: #059669 !important;
        }

        /* Search input */
        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #22c55e;
            border-radius: 6px;
            padding: 4px 10px;
            width: 180px;
            /* lebih kecil */
            font-size: 0.85rem;
            transition: border-color 0.3s ease;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #16a34a;
            box-shadow: 0 0 6px #16a34a;
        }

        /* Modal */
        .custom-modal>div {
            max-width: 400px;
            /* modal lebih kecil */
            padding: 20px;
            border-radius: 12px;
        }

        /* Form inputs */
        select,
        input[type="text"] {
            border: 2px solid #22c55e;
            border-radius: 6px;
            padding: 6px 10px;
            width: 100%;
            font-size: 0.85rem;
            transition: border-color 0.3s ease;
        }

        select:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: #16a34a;
            box-shadow: 0 0 6px #16a34a;
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
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $complaint->latitude }},{{ $complaint->longitude }}" class="text-blue-600 underline" target="_blank">
                                            {{ $complaint->latitude }}, {{ $complaint->longitude }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">Perum Rabany Regency</td>
                                    <td class="px-4 py-2 flex gap-2">
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $complaint->latitude }},{{ $complaint->longitude }}" target="_blank" class="btn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-300 w-20">Lihat Lokasi</a>
                                        <a href="{{ route('petugas.complaints.show', $complaint->id) }}" class="btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300 w-20">
                                            Detail
                                        </a>
                                        @if ($complaint->proof === null)
                                            <a href="{{ route('petugas.proof.create', $complaint->id) }}" class="btn bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-300 w-20">
                                                Kirim Bukti
                                                @if (!$complaint->read_by_assigned_user)
                                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                                                        !
                                                    </span>
                                                @endif
                                            </a>
                                        @endif
                                        @if ($complaint->status === 'ditolak')
                                            <a href="{{ route('petugas.proof.show', $complaint->proof->id ?? 0) }}" class="btn bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-300 w-20" disabled>
                                                Lihat Bukti
                                            </a>
                                        @else
                                            @if ($complaint->proof)
                                                <a href="{{ route('petugas.proof.show', $complaint->proof->id ?? 0) }}" class="btn bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-300 w-20">
                                                    Lihat Bukti
                                                </a>
                                            @endif
                                        @endif

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
                    lengthMenu: "Tampilkan _MENU_",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "→",
                        previous: "←"
                    },
                    zeroRecords: "Tidak ada data yang ditemukan",
                }
            });
        });
    </script>
@endsection
