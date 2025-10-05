@extends('layout.app')
@section('title', 'User')
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
                <h2 class="text-3xl font-extrabold text-green-700">Manajemen User</h2>
                <div>
                    <button type="button" onclick="openModal('modal-reset-1')" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 whitespace-nowrap mr-2">
                        Reset Exp & Point
                    </button>
                    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 whitespace-nowrap">
                        + Tambah User
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg">
                <table id="userTable" class="min-w-full">
                    <thead>
                        <tr>
                            <th class="text-left text-sm font-semibold">Nama</th>
                            <th class="text-left text-sm font-semibold">Email</th>
                            <th class="text-left text-sm font-semibold">Role</th>
                            <th class="text-left text-sm font-semibold">Badge</th>
                            <th class="text-left text-sm font-semibold">EXP</th>
                            <th class="text-left text-sm font-semibold">Point</th>
                            <th class="text-left text-sm font-semibold">Status</th>
                            <th class="text-left text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="text-gray-800 px-4 py-4 text-sm">{{ $user->name }}</td>
                            <td class="text-gray-800 px-4 py-4 text-sm">{{ $user->email }}</td>
                            <td class="text-gray-800 px-4 py-4 text-sm">{{ $user->role->name }}</td>
                            <td class="text-gray-800 px-4 py-4 text-sm">@if($user->role_id == 2)
                                -
                                @else
                                {{ $user->tier_icon . " - " . ucfirst($user->tier) }}
                                @endif
                            </td>
                            <td class="text-gray-800 px-4 py-4 text-sm">@if($user->role_id == 2)
                                -
                                @else
                                {{ number_format($user->exp) }}
                                @endif
                            </td>
                            <td class="text-gray-800 px-4 py-4 text-sm">
                                @if($user->role_id == 2)
                                -
                                @else
                                {{ number_format($user->points) }}
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <button onclick="openModal('modal-status-{{ $user->id }}')" class="focus:outline-none">
                                    @switch($user->status)
                                    @case('active')
                                    <span class="inline-block bg-green-500 text-white px-4 py-1 rounded-full text-xs font-semibold w-30">Aktif</span>
                                    @break

                                    @case('nonactive')
                                    <span class="inline-block bg-gray-400 text-white px-4 py-1 rounded-full text-xs font-semibold w-30">Nonaktif</span>
                                    @break

                                    @case('belum diverifikasi')
                                    <span class="relative inline-block bg-yellow-400 text-white px-4 py-1 rounded-full text-xs font-semibold w-30">Belum
                                        Diverifikasi
                                        @if (!$user->is_read_by_admin)
                                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                                            !
                                        </span>
                                        @endif
                                    </span>
                                    @break
                                    @endswitch
                                </button>
                            </td>
                            <td class="space-x-2">
                                <a href="{{ route('users.show', $user->id) }}"
                                    class="btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-xs rounded-lg">Lihat</a>
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="btn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded-lg shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-300 w-20">Edit</a>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-lg">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($users as $user)
    <!-- Modal untuk edit status -->
    <div id="modal-status-{{ $user->id }}" class="custom-modal fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl max-w-md w-full p-8 relative">
            <button onclick="closeModal('modal-status-{{ $user->id }}')" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 focus:outline-none text-2xl">&times;</button>
            <h3 class="text-lg font-bold mb-4">Ubah Status User</h3>
            <form action="{{ route('users.updateStatus', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <label for="status-{{ $user->id }}" class="block mb-2 font-semibold">Status</label>
                <select name="status" id="status-{{ $user->id }}" required>
                    <option value="active" @if ($user->status == 'active') selected @endif>Aktif</option>
                    <option value="nonactive" @if ($user->status == 'nonactive') selected @endif>Nonaktif</option>
                    <option value="belum diverifikasi" @if ($user->status == 'belum diverifikasi') selected @endif>Belum
                        Diverifikasi</option>
                </select>

                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('modal-status-{{ $user->id }}')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
    <div id="modal-reset-1" class="custom-modal fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl max-w-md w-full p-8 relative">
            <button onclick="closeModal('modal-reset-1')" class="absolute top-3 right-3 text-gray-600 hover:text-white focus:outline-none text-2xl">&times;</button>
            <h3 class="text-lg font-bold mb-4">Reset Exp dan Poin</h3>
            <form action="{{ route('user.reset') }}" method="POST">
                @csrf
                <h4>Apakah anda yakin ingin me reset exp dan point masyarakat ?</h4>
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('modal-reset-1')" class="px-4 py-2 bg-green-300 rounded hover:bg-green-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Reset</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "pageLength": 10,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 100],
                [10, 25, 100]
            ], // opsi jumlah data yang bisa dipilih
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
    });

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openModalReset(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModalReset(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endsection