@extends('layout.app')
@section('title', 'DLH Garut')
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
                <h2 class="text-3xl font-extrabold text-green-700 mb-6">Daftar Pengaduan</h2>
                <a href="{{ route('complaint.create') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 whitespace-nowrap">
                    + Tambah Pengaduan
                </a>
            </div>

            <div class="overflow-x-auto ">
                <table id="complaintTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#007546] text-white">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Tanggal</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Pengirim</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Judul</th>
                            {{-- <th class="px-4 py-2 text-left text-sm font-semibold">Titik Koordinat</th> --}}
                            <th class="px-4 py-2 text-left text-sm font-semibold">Alamat</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($complaints as $complaint)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ $complaint->created_at->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->user->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->title }}</td>

                            {{-- <td class="px-4 py-2 text-sm text-blue-600 underline">
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $complaint->latitude }},{{ $complaint->longitude }}"
                            class="text-blue-600 underline" target="_blank">
                            {{ $complaint->latitude }}, {{ $complaint->longitude }}
                            </a>
                            </td> --}}
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->full_address }}</td>

                            <td class="px-4 py-2 text-sm">
                                <span class="px-3 py-1 text-xs rounded-full text-white {{ $complaint->status === 'diproses' ? 'bg-yellow-500' : ($complaint->status === 'selesai' ? 'bg-green-500' : ($complaint->status === 'ditolak' ? 'bg-red-500' : 'bg-gray-500')) }}">
                                    {{ ucfirst($complaint->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-1">
                                    {{-- Detail --}}
                                    <a target="_blank" href="https://www.google.com/maps/dir/?api=1&destination={{ $complaint->latitude }},{{ $complaint->longitude }}" target="_blank" class="btn bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-300 w-20">
                                        Lihat Lokasi
                                    </a>

                                    <a href="{{ route('complaints.show', $complaint->id) }}" class="btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300 w-20">
                                        Detail
                                    </a>
                                    <!-- @if ($complaint->status === 'selesai' && $complaint->proof)

                                    <a href="{{ route('admin.complaints.print.proof', $complaint->id) }}" target="_blank" class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 w-25">
                                        Print Bukti Penyelesaian
                                    </a>
                                    @endif -->

                                    {{-- Print Lengkap --}}
                                    @if ($complaint->status === 'selesai' && $complaint->proof)
                                    <a href="{{ route('admin.complaints.print.complete', $complaint->id) }}" target="_blank" class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 w-20">
                                        Print Laporan
                                    </a>
                                    @endif
                                    <!-- {{-- Lihat Bukti & Print Bukti --}}
                                    @if ($complaint->status === 'diproses' && $complaint->proof)
                                    <a href="{{ route('admin.complaints.show.proof', $complaint->proof->id ?? 0) }}" class="btn bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-300 w-20">
                                        Lihat Bukti
                                    </a>
                                    <a href="{{ route('admin.complaints.print.proof', $complaint->id) }}" target="_blank" class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 w-25">
                                        Print Bukti Penyelesaian
                                    </a>
                                    @endif

                                    {{-- Print Detail Pengaduan --}}
                                    @if ($complaint->status === 'terkirim')
                                    <a href="{{ route('admin.complaints.print', $complaint->id) }}" target="_blank" class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 w-20">
                                        Print Detail Pengaduan
                                    </a>
                                    @endif

                                    {{-- Print Lengkap --}}
                                    {{-- @if ($complaint->status === 'selesai')
                                                <a href="{{ route('admin.complaints.print.complete', $complaint->id) }}" target="_blank" class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 w-30">
                                    Print Seluruh Data
                                    </a>
                                    @endif --}} -->
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

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }


    function printComplaint(id) {
        const modal = document.getElementById(`modal-detail-${id}`);
        const printContent = modal.innerHTML;
        const printWindow = window.open('', '', 'height=500,width=800');
        printWindow.document.write('<html><head><title>Cetak Pengaduan</title>');
        printWindow.document.write(
            '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">');
        printWindow.document.write('</head><body class="p-6 text-black">');
        printWindow.document.write(printContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => printWindow.print(), 500);
    }
</script>
@endsection
