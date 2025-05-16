@extends('layout.app')

@section('style')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Warna teks hitam */
        table.dataTable,
        table.dataTable td,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_paginate {
            color: #000 !important;
        }

        /* Gaya pagination */
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
            <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-3xl p-8">
                <h2 class="text-2xl font-bold text-[#F17025] mb-6">Riwayat Pengaduan Saya</h2>

                @if ($complaints->isEmpty())
                    <p class="text-black">Kamu belum mengirimkan pengaduan apapun.</p>
                @else
                    <div class="overflow-x-auto">
                        <table id="complaintsTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#007546] text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">Judul</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">Kecamatan</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">Alamat</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">Tanggal</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($complaints as $complaint)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->title }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->kecamatan }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $complaint->full_address }}</td>
                                        <td class="px-4 py-2">
                                            @switch($complaint->status)
                                                @case('Terkirim')
                                                    <span
                                                        class="inline-block bg-gray-400 text-white text-xs font-semibold px-3 py-1 rounded-full">Terkirim</span>
                                                @break

                                                @case('Diterima')
                                                    <span
                                                        class="inline-block bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Diterima</span>
                                                @break

                                                @case('Ditolak')
                                                    <span
                                                        class="inline-block bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Ditolak</span>
                                                @break

                                                @case('Diproses')
                                                    <span
                                                        class="inline-block bg-yellow-400 text-black text-xs font-semibold px-3 py-1 rounded-full">Diproses</span>
                                                @break

                                                @case('Selesai')
                                                    <span
                                                        class="inline-block bg-blue-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Selesai</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-600">
                                            {{ $complaint->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('complaints.show', $complaint->id) }}"
                                                class="inline-block bg-[#F17025] hover:bg-orange-600 text-white text-xs font-semibold px-4 py-2 rounded-full transition-all duration-300">
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('script')
    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#complaintsTable').DataTable({
                responsive: true,
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
    </script>
@endsection
