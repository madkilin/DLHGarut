@extends('layout.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        table.dataTable,
        table.dataTable td,
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
            <div class="max-w-8xl mx-auto bg-white shadow-lg rounded-3xl p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-[#F17025]">Manajemen User</h2>
                    <a href="{{ route('users.create') }}"
                        class="bg-[#007546] hover:bg-green-700 text-white px-4 py-2 rounded-full text-sm font-semibold">+
                        Tambah User</a>
                </div>

                <div class="overflow-x-auto">
                    <table id="userTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#007546] text-white">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Nama</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Email</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        <button onclick="openModal('modal-status-{{ $user->id }}')"
                                            class="focus:outline-none">
                                            @switch($user->status)
                                                @case('active')
                                                    <span
                                                        class="bg-green-500 text-white px-3 py-1 text-xs rounded-full">Aktif</span>
                                                @break

                                                @case('nonactive')
                                                    <span
                                                        class="bg-gray-400 text-white px-3 py-1 text-xs rounded-full">Nonaktif</span>
                                                @break

                                                @case('belum diverifikasi')
                                                    <span class="bg-yellow-400 text-black px-3 py-1 text-xs rounded-full">Belum
                                                        Diverifikasi</span>
                                                @break
                                            @endswitch
                                        </button>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('users.show', $user->id) }}"
                                            class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-md">Lihat</a>
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-xs rounded-full">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-full"
                                                type="submit">Hapus</button>
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
            <div id="modal-status-{{ $user->id }}"
                class="custom-modal fixed inset-0 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-xl p-6 w-full max-w-md text-black">
                    <h3 class="text-xl font-semibold mb-4">Ubah Status: {{ $user->name }}</h3>
                    <form action="{{ route('users.updateStatus', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4 text-black">
                            <label for="status-{{ $user->id }}" class="block font-semibold mb-1">Status</label>
                            <select name="status" id="status-{{ $user->id }}"
                                onchange="handleStatusChange(this, 'desc-field-{{ $user->id }}')"
                                class="w-full px-3 py-2 border rounded-lg">
                                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonactive" {{ $user->status === 'nonactive' ? 'selected' : '' }}>Nonaktif
                                </option>
                                <option value="belum diverifikasi"
                                    {{ $user->status === 'belum diverifikasi' ? 'selected' : '' }}>Belum Diverifikasi
                                </option>
                            </select>
                        </div>

                        <div id="desc-field-{{ $user->id }}"
                            class="mb-4 {{ $user->status !== 'nonactive' ? 'hidden' : '' }}">
                            <label for="desc" class="block font-semibold mb-1">Keterangan</label>
                            <select name="keterangan" id="keterangan-{{ $user->id }}"
                                onchange="handleKeteranganChange(this, 'keterangan-manual-{{ $user->id }}')"
                                class="w-full px-3 py-2 border rounded-lg mb-2">
                                <option value="">-- Pilih Alasan --</option>
                                <option value="Anda melanggar ketentuan kami">Anda melanggar ketentuan kami</option>
                                <option value="manual">Tulis Manual</option>
                            </select>
                            <input type="text" name="keterangan_manual" id="keterangan-manual-{{ $user->id }}"
                                placeholder="Tulis alasan manual..."
                                class="w-full px-3 py-2 border rounded-lg mt-2 hidden" />
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeModal('modal-status-{{ $user->id }}')"
                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-[#007546] text-white rounded hover:bg-green-700">Simpan</button>
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
            $('#userTable').DataTable({
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
        // modal
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        function handleStatusChange(selectElem, inputId) {
            const selectedValue = selectElem.value;
            const descriptionField = document.getElementById(inputId);

            if (selectedValue === 'nonactive') {
                descriptionField.classList.remove('hidden');
            } else {
                descriptionField.classList.add('hidden');
            }
        }

        function handleKeteranganChange(selectElem, inputId) {
            const selectedValue = selectElem.value;
            const manualInput = document.getElementById(inputId);

            if (selectedValue === 'manual') {
                manualInput.classList.remove('hidden');
            } else {
                manualInput.classList.add('hidden');
            }
        }
    </script>
@endsection
