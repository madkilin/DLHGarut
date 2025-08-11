@extends('layout.app')
@section('title', 'Reward')
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
    <section class="py-20 bg-gradient-to-br from-green-50 via-green-100 to-green-50 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-10">
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <h2 class="text-3xl font-extrabold text-green-700 mb-6">Daftar Hadiah</h2>
                    <a href="{{ route('reward.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 whitespace-nowrap">
                        + Tambah Hadiah
                    </a>
                </div>
                <div class="overflow-x-auto ">
                    <table id="complaintTable" class="min-w-full divide-y divide-gray-200" width="100%">
                        <thead class="bg-[#007546] text-white">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold" width="5%">No</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Nama</th>
                                <th class="px-4 py-2 text-center text-sm font-semibold" width="10%">Quota</th>
                                <th class="px-4 py-2 text-center text-sm font-semibold" width="10%">Point</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($rewards as $key => $reward)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reward->name }}</td>
                                    <td>{{ $reward->quota }}</td>
                                    <td>{{ $reward->point }}</td>
                                    <td>
                                        <div class="flex">
                                            <a href="{{ route('reward.show', $reward->id) }}" class="relative btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300 w-20 mr-2">Lihat
                                            </a>
                                            <a href="{{ route('reward.edit', $reward->id) }}" class="relative btn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300 w-20">Edit
                                            </a>
                                        </div>
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
            $('#complaintTable').DataTable({
                pageLength: 10,
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
