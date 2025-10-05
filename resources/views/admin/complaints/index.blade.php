@extends('layout.app')
@section('title','Pengaduan')
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
        @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-10">
            <h2 class="text-3xl font-extrabold text-green-700 mb-6">Daftar Pengaduan</h2>
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
                                <span
                                    class="px-3 py-1 text-xs rounded-full text-white {{ $complaint->status === 'diproses'
                                                ? 'bg-yellow-500'
                                                : ($complaint->status === 'selesai'
                                                    ? 'bg-green-500'
                                                    : ($complaint->status === 'ditolak'
                                                        ? 'bg-red-500'
                                                        : 'bg-gray-500')) }}">
                                    {{ ucfirst($complaint->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-1 items-center justify-center">
                                    {{-- Detail --}}
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $complaint->latitude }},{{ $complaint->longitude }}"
                                        target="_blank"
                                        class="btn bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-300 w-20">
                                        Lihat Lokasi
                                    </a>

                                    <a href="{{ route('admin.complaints.show', $complaint->id) }}"
                                        class="btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300 w-20">
                                        Detail
                                    </a>

                                    {{-- Ubah Status --}}
                                    @if ($complaint->status === 'ditolak' || $complaint->status === 'selesai')
                                    <button onclick="openModal('modal-status-{{ $complaint->id }}')" disabled
                                        class="bg-gray-400 text-white px-3 py-1 text-xs rounded-lg opacity-60 cursor-not-allowed w-20">
                                        Ubah Status
                                    </button>
                                    @else
                                    <button onclick="openModal('modal-status-{{ $complaint->id }}')"
                                        class="relative btn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-300 w-20">
                                        Ubah Status
                                        @if (!$complaint->read_by_admin)
                                        <span
                                            class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                                            !
                                        </span>
                                        @endif
                                    </button>
                                    @endif

                                    {{-- Tugas / Print Tugas --}}
                                    @if ($complaint->status === 'diproses' && $complaint->assigned_to === null)
                                    <button onclick="openModal('modal-assign-{{ $complaint->id }}')"
                                        class="btn bg-green-600 hover:bg-green-700 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-300 w-20">
                                        Berikan Tugas
                                    </button>
                                    @endif

                                    {{-- Lihat Bukti & Print Bukti --}}
                                    @if ($complaint->status === 'diproses' && $complaint->proof)
                                    <a href="{{ route('admin.complaints.show.proof', $complaint->proof->id ?? 0) }}"
                                        class="btn bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-300 w-20">
                                        Lihat Bukti
                                    </a>
                                    <a href="{{ route('admin.complaints.print.proof', $complaint->id) }}"
                                        target="_blank"
                                        class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 w-25">
                                        Print Bukti Penyelesaian
                                    </a>
                                    @endif

                                    {{-- Print Detail Pengaduan --}}
                                    @if ($complaint->status === 'terkirim')
                                    <a href="{{ route('admin.complaints.print', $complaint->id) }}"
                                        target="_blank"
                                        class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 w-20">
                                        Print Detail Pengaduan
                                    </a>
                                    @endif

                                    {{-- Print Lengkap --}}
                                    @if ($complaint->status === 'selesai')
                                    <a href="{{ route('admin.complaints.print.complete', $complaint->id) }}"
                                        target="_blank"
                                        class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 w-20">
                                        Print Laporan
                                    </a>
                                    @endif
                                </div>
                            </td>

                        </tr>

                        <!-- Modal Ubah Status -->
                        <div id="modal-status-{{ $complaint->id }}"
                            class="custom-modal fixed inset-0 flex items-center justify-center hidden z-50">
                            <div class="bg-white rounded-xl p-6 w-full max-w-md text-black">
                                <h3 class="text-xl font-semibold mb-4">Ubah Status Pengaduan</h3>
                                <form action="{{ route('admin.complaints.updateStatus', $complaint->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label class="block font-semibold mb-1">Status</label>
                                        @php
                                        $status = $complaint->status;
                                        @endphp

                                        <select name="status"
                                            onchange="handleStatusChange(this, {{ $complaint->id }})"
                                            class="w-full px-3 py-2 border rounded-lg">
                                            <option value="">-- Pilih Status --</option>

                                            @if ($status === 'terkirim')
                                            <option value="diterima">Diterima</option>
                                            <option value="ditolak">Ditolak</option>
                                            @elseif ($status === 'diterima')
                                            <option value="diproses">Diproses</option>
                                            <option value="ditolak">Ditolak</option>
                                            @elseif ($status === 'diproses')
                                            @if ($complaint->proof)
                                            <option value="selesai">Selesai (sudah ada bukti)
                                            </option>
                                            @else
                                            <option value="selesai" disabled>Selesai</option>
                                            @endif
                                            @elseif ($status === 'ditolak')
                                            <option disabled selected>Tidak ada tindakan lanjutan</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div id="reason-container-{{ $complaint->id }}" class="mb-4 hidden">
                                        <label class="block font-semibold mb-1">Alasan Penolakan</label>
                                        <select name="note_option"
                                            onchange="handleNoteOption(this, {{ $complaint->id }})"
                                            class="w-full px-3 py-2 border rounded-lg">
                                            <option value="Data tidak lengkap">Data tidak lengkap</option>
                                            <option value="manual">Manual</option>
                                        </select>
                                    </div>

                                    <div id="note-container-{{ $complaint->id }}" class="mb-4 hidden">
                                        <label class="block font-semibold mb-1">Catatan Manual</label>
                                        <textarea name="note" id="note-{{ $complaint->id }}" rows="3"
                                            class="w-full px-3 py-2 border rounded-lg"
                                            @if(in_array($complaint->status, ['diproses','ditolak'])) required @endif
></textarea>
                                    </div>

                                    <div class="flex justify-end gap-2">
                                        <button type="button"
                                            onclick="closeModal('modal-status-{{ $complaint->id }}')"
                                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-[#007546] text-white rounded hover:bg-green-700">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Berikan Tugas -->
    @foreach ($complaints as $complaint)
    <div id="modal-assign-{{ $complaint->id }}"
        class="custom-modal fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md text-black">
            <h3 class="text-xl font-semibold mb-4">Berikan Tugas ke Staff</h3>
            <form action="{{ route('admin.complaints.assignTask', $complaint->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="assigned_to" class="block font-semibold mb-1">Pilih Staff</label>
                    <select name="assigned_to" id="assigned_to" class="w-full px-3 py-2 border rounded-lg"
                        required>
                        <option value="">-- Pilih Staff --</option>
                        @foreach ($availableStaff as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modal-assign-{{ $complaint->id }}')"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Kirim Tugas</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
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

    function handleStatusChange(select, id) {
        const status = select.value;
        const reasonContainer = document.getElementById(`reason-container-${id}`);
        const noteContainer = document.getElementById(`note-container-${id}`);
        const noteInput = document.getElementById(`note-${id}`);
        const noteOptionSelect = document.querySelector(`select[name="note_option"][onchange*="${id}"]`);

        // Reset semua
        noteInput.value = '';
        if (noteOptionSelect) noteOptionSelect.value = '';

        if (status === 'ditolak') {
            reasonContainer.classList.remove('hidden');
            noteContainer.classList.add('hidden');
        } else if (status === 'diproses' || status === 'selesai') {
            reasonContainer.classList.add('hidden');
            noteContainer.classList.remove('hidden');
        } else {
            reasonContainer.classList.add('hidden');
            noteContainer.classList.add('hidden');
        }
    }

    function handleNoteOption(select, id) {
        const noteContainer = document.getElementById(`note-container-${id}`);
        const noteInput = document.getElementById(`note-${id}`);

        if (select.value === 'manual') {
            noteContainer.classList.remove('hidden');
            noteInput.value = '';
        } else {
            noteContainer.classList.add('hidden');
            noteInput.value = select.value; // langsung masukkan isi ke input tersembunyi
        }
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