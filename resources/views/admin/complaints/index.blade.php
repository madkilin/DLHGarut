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
            <h2 class="text-2xl font-bold text-[#F17025] mb-6">Daftar Pengaduan</h2>
            <div class="overflow-x-auto">
                <table id="complaintTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#007546] text-white">
    <tr>
        <th class="px-4 py-2 text-left text-sm font-semibold">Tanggal</th>
        <th class="px-4 py-2 text-left text-sm font-semibold">Pengirim</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Judul</th>
        <th class="px-4 py-2 text-left text-sm font-semibold">Titik Koordinat</th>
        <th class="px-4 py-2 text-left text-sm font-semibold">Alamat</th>
        <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
        <th class="px-4 py-2 text-left text-sm font-semibold">Aksi</th>
    </tr>
</thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($complaints as $complaint)
                        <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->created_at->format('d-m-Y') }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->user->name }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->title }}</td>

<td class="px-4 py-2 text-sm text-blue-600 underline">
    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $complaint->latitude }},{{ $complaint->longitude }}" target="_blank">
        {{ $complaint->latitude }}, {{ $complaint->longitude }}
    </a>
</td>        <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->full_address }}</td>

                            <td class="px-4 py-2 text-sm">
                                <span class="px-3 py-1 text-xs rounded-full text-white {{ 
                                    $complaint->status === 'diproses' ? 'bg-yellow-500' : (
                                    $complaint->status === 'selesai' ? 'bg-green-500' : (
                                    $complaint->status === 'ditolak' ? 'bg-red-500' : 'bg-gray-500') ) }}">
                                    {{ ucfirst($complaint->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <button onclick="openModal('modal-detail-{{ $complaint->id }}')"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-xs rounded-full">Detail</button>

                                <button onclick="openModal('modal-status-{{ $complaint->id }}')"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded-full">Ubah Status</button>

@if ($complaint->status === 'diproses' && $complaint->assigned_to === null) 
     <button onclick="openModal('modal-assign-{{ $complaint->id }}')"
    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 text-xs rounded-full">Berikan Tugas</button>
@endif
                                   
                                <button onclick="printComplaint({{ $complaint->id }})"


                                    class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 text-xs rounded-full">Print</button>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div id="modal-detail-{{ $complaint->id }}"
                            class="custom-modal fixed inset-0 flex items-center justify-center hidden z-50">
                            <div class="bg-white rounded-xl p-6 w-full max-w-lg text-black">
                                <h3 class="text-xl font-semibold mb-4">Detail Pengaduan</h3>
                                <div>
                                    <p><strong>Nama:</strong> {{ $complaint->user->name }}</p>
                                    <p><strong>Judul:</strong> {{ $complaint->title }}</p>
                                    <p><strong>Isi:</strong> {{ $complaint->content }}</p>
                                    <p><strong>Status:</strong> {{ $complaint->status }}</p>
                                    <p><strong>Catatan:</strong> {{ $complaint->note ?? '-' }}</p>
                                </div>
                                <div class="mt-4 text-right">
                                    <button type="button" onclick="closeModal('modal-detail-{{ $complaint->id }}')"
                                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Ubah Status -->
                        <div id="modal-status-{{ $complaint->id }}"
                            class="custom-modal fixed inset-0 flex items-center justify-center hidden z-50">
                            <div class="bg-white rounded-xl p-6 w-full max-w-md text-black">
                                <h3 class="text-xl font-semibold mb-4">Ubah Status Pengaduan</h3>
                                <form action="{{ route('admin.complaints.updateStatus', $complaint->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
    <label class="block font-semibold mb-1">Status</label>
    <select name="status" onchange="handleStatusChange(this, {{ $complaint->id }})"
        class="w-full px-3 py-2 border rounded-lg">
        <option value="diterima"
            {{ $complaint->status === 'diterima' ? 'selected' : '' }}
            {{ in_array($complaint->status, ['diproses', 'ditolak', 'selesai']) ? 'disabled' : '' }}>
            Diterima
        </option>
        <option value="diproses" {{ $complaint->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
        <option value="ditolak" {{ $complaint->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        <option value="selesai" {{ $complaint->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
    </select>
</div>

                                    <div id="reason-container-{{ $complaint->id }}" class="mb-4 hidden">
                                        <label class="block font-semibold mb-1">Alasan Penolakan</label>
                                        <select name="note_option" onchange="handleNoteOption(this, {{ $complaint->id }})"
                                            class="w-full px-3 py-2 border rounded-lg">
                                            <option value="Data tidak lengkap">Data tidak lengkap</option>
                                            <option value="manual">Manual</option>
                                        </select>
                                    </div>

                                    <div id="note-container-{{ $complaint->id }}" class="mb-4 hidden">
                                        <label class="block font-semibold mb-1">Catatan Manual</label>
                                        <textarea name="note" id="note-{{ $complaint->id }}" rows="3"
                                            class="w-full px-3 py-2 border rounded-lg"></textarea>
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
                <select name="assigned_to" id="assigned_to" class="w-full px-3 py-2 border rounded-lg" required>
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
    $(document).ready(function () {
        $('#complaintTable').DataTable({
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
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">');
        printWindow.document.write('</head><body class="p-6 text-black">');
        printWindow.document.write(printContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => printWindow.print(), 500);
    }
</script>
@endsection
