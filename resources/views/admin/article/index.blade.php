@extends('layout.app')
@section('title','Artikel')
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
        }

        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0 6px !important;
        }

        table.dataTable thead th {
            background-color: #22c55e;
            color: white !important;
            font-weight: 600;
            border-radius: 6px 6px 0 0;
            padding: 8px 12px !important;
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
            vertical-align: middle;
            border: none !important;
            font-size: 0.85rem;
        }

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

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #22c55e;
            border-radius: 6px;
            padding: 4px 10px;
            width: 180px;
            font-size: 0.85rem;
            transition: border-color 0.3s ease;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #16a34a;
            box-shadow: 0 0 6px #16a34a;
        }

        .custom-modal>div {
            max-width: 400px;
            padding: 20px;
            border-radius: 12px;
        }

        select,
        input[type="text"],
        textarea {
            border: 2px solid #22c55e;
            border-radius: 6px;
            padding: 6px 10px;
            width: 100%;
            font-size: 0.85rem;
            transition: border-color 0.3s ease;
        }

        select:focus,
        input[type="text"]:focus,
        textarea:focus {
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
                    <h2 class="text-3xl font-extrabold text-green-700">Manajemen Artikel</h2>
                    <a href="{{ route('admin.articles.create') }}"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 whitespace-nowrap">
                        + Tambah Artikel
                    </a>
                </div>

                <div class="overflow-x-auto rounded-lg">
                    <table id="articleTable" class="min-w-full">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr>
                                    <td>{{ $article->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->user->name }}</td>
                                    <td>{{ $article->slug }}</td>
                                    <td>
                                        <button onclick="openModal('modal-status-{{ $article->id }}')" class="focus:outline-none">
                                            @if ($article->is_read_by_admin == 1)
                                                <span class="inline-block bg-green-500 text-white px-4 py-1 rounded-full text-xs font-semibold">Konfirmasi</span>
                                            @elseif ($article->is_read_by_admin == -1)
                                                <span class="inline-block bg-red-500 text-white px-4 py-1 rounded-full text-xs font-semibold">Tolak</span>
                                            @else
                                                <span class="inline-block bg-yellow-500 text-white px-4 py-1 rounded-full text-xs font-semibold">Menunggu</span>
                                            @endif
                                        </button>
                                    </td>
                                    <td class="space-x-2">
                                        <a href="{{ route('admin.articles.show', $article) }}"
                                            class="btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-xs rounded-lg">Lihat</a>
                                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-lg">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @foreach ($articles as $article)
            <!-- Modal Ubah Status -->
            <div id="modal-status-{{ $article->id }}" class="custom-modal fixed inset-0 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-xl max-w-md w-full p-8 relative">
                    <button onclick="closeModal('modal-status-{{ $article->id }}')" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
                    <h3 class="text-lg font-bold mb-4">Ubah Status Artikel</h3>
                    <form action="{{ route('article.update-status', $article->id) }}" method="POST" onsubmit="return validateForm({{ $article->id }})">
                        @csrf
                        @method('PUT')

                        <label for="status-{{ $article->id }}" class="block mb-2 font-semibold">Status</label>
                        <select name="status" id="status-{{ $article->id }}" required onchange="toggleReasonField({{ $article->id }})">
                            <option disabled selected>-- Pilih Status --</option>
                            <option value="1" @if ($article->status == '1') selected @endif>Konfirmasi</option>
                            <option value="0" @if ($article->status == '0') selected @endif>Menunggu</option>
                            <option value="-1" @if ($article->status == '-1') selected @endif>Tolak</option>
                        </select>

                        <!-- Alasan Penolakan -->
                        <div id="reason-field-{{ $article->id }}" class="mt-4 hidden">
                            <label for="reason-{{ $article->id }}" class="block mb-2 font-semibold">Alasan Penolakan</label>
                            <textarea name="reason" id="reason-{{ $article->id }}" rows="3"
                                class="border-2 border-red-400 rounded-md w-full p-2 text-sm"></textarea>
                        </div>

                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" onclick="closeModal('modal-status-{{ $article->id }}')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </section>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#articleTable').DataTable({
                "pageLength": 10,
                "lengthChange": true,
                "order": [[0, "desc"]],
                "lengthMenu": [[10, 25, 100], [10, 25, 100]],
                "language": {
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
                },
            });

            // inisialisasi semua modal biar langsung sinkron sama status awal
            @foreach ($articles as $article)
                toggleReasonField({{ $article->id }});
            @endforeach
        });

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function toggleReasonField(id) {
            let status = document.getElementById('status-' + id).value;
            let reasonField = document.getElementById('reason-field-' + id);

            if (status == '-1') {
                reasonField.classList.remove('hidden');
            } else {
                reasonField.classList.add('hidden');
            }
        }

        function validateForm(id) {
            let status = document.getElementById('status-' + id).value;
            let reason = document.getElementById('reason-' + id).value.trim();

            if (status == '-1' && reason === '') {
                alert('Harap isi alasan penolakan.');
                return false;
            }
            return true;
        }
    </script>
@endsection
