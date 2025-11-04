<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dokumen Laporan dan Hasil Penyelesaian Pengaduan Masyarakat</title>
    <style>
        body {
            font-family: sans-serif;
            /* font-family: 'Times New Roman'; */
            margin: 2cm;
        }

        .header {
            text-align: center;
            margin-bottom: 2em;
        }

        .section {
            margin-bottom: 1.5em;
        }

        .label {
            font-weight: bold;
        }

        .photo-container img {
            width: 150px;
            height: 150px;
            margin: 5px;
            border: 1px solid #ccc;
            object-fit: cover;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button onclick="window.print()">Cetak Laporan dan Hasil Penyelesaian </button>

    <div class="header">
        <h1>Detail Laporan Pengaduan Masyarakat</h1>
        <!-- <p>Nomor Surat: 001/SPM/{{ date('Y') }}</p> -->
        <!-- <p>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p> -->
    </div>

    <div class="section">
        <label class="label">Pengadu</label>
        <ul class="list-disc list-inside text-gray-700">
            <li><strong>Nama:</strong> {{ $complaint->user->name }}</li>
            <li><strong>NIK:</strong> {{ $complaint->user->nik }}</li>
            <li><strong>Telepon:</strong> {{ $complaint->user->phone }}</li>
            <li><strong>Email:</strong> {{ $complaint->user->email }}</li>
        </ul>
    </div>
    <br>
    <div class="section">
        <div class="label">Tanggal Pengaduan:</div>
        <div>{{ \Carbon\Carbon::parse($complaint->created_at)->locale('id')->translatedFormat('d F Y') }}</div>

    </div>
    <div class="section">
        <div class="label">Judul Pengaduan:</div>
        <div>{{ $complaint->title }}</div>
    </div>
    <div class="section">
        <div class="label">Deskripsi Pengaduan:</div>
        <div>{!! $complaint->description !!}</div>
    </div>
    <div class="section">
        <div class="label">Lokasi Pengaduan:</div>
        <a href="https://www.google.com/maps?q={{ $complaint->latitude }},{{ $complaint->longitude }}" target="_blank">
            https://www.google.com/maps?q={{ $complaint->latitude }},{{ $complaint->longitude }} </a><br>
        <div>Koordinat: {{ $complaint->latitude }}, {{ $complaint->longitude }}</div>
        <div>{{ $complaint->kabupaten }}, {{ $complaint->kecamatan }} , {{ $complaint->desa }}</div>
        <div>{{ $complaint->full_address }}</div>
    </div>

    @php
    $photos = is_array($complaint->photos) ? $complaint->photos : json_decode($complaint->photos, true);
    @endphp

    @if (!empty($photos))
    <div class="section">
        <div class="label">Foto Pengaduan:</div>
        <div class="photo-container">
            @foreach ($photos as $photo)
            <img src="{{ asset('storage/' . $photo) }}" alt="Foto Pengaduan">
            @endforeach
        </div>
    </div>
    @endif


    @if ($complaint->proof)
    <!-- PEMISAH HALAMAN -->
    <div style="page-break-before: always;"></div>

    <div class="header">
        <h1>Hasil Penyelesaian Pengaduan Masyarakat</h1>
    </div>

    <div class="section">
        <div class="label">Tanggal Penyelesaian:</div>
        <div>{{ \Carbon\Carbon::parse($complaint->proof->created_at)->locale('id')->translatedFormat('d F Y') }}</div>
    </div>

    <div class="section">
        <div class="label">Deskripsi Penyelesaian:</div>
        <div>{{ $complaint->proof->description }}</div>
    </div>
    <div class="section">
        <div class="label">Jumlah Sampah:</div>
        <div>{{ $complaint->proof->amount }} {{ $complaint->proof->unit }}</div>
    </div>
    <div class="section">
        <div class="label">Petugas:</div>
        @if (!empty($complaint->proof->officers) && is_array($complaint->proof->officers))
        <ul class="list-disc list-inside">
            @foreach ($complaint->proof->officers as $officer)
            <li>{{ $officer }}</li>
            @endforeach
        </ul>
        @else
        <p>-</p>
        @endif
    </div>

    @php
    $proofPhotos = is_array($complaint->proof->photos ?? [])
    ? $complaint->proof->photos
    : json_decode($complaint->proof->photos ?? '[]', true);
    @endphp

    @if (!empty($proofPhotos))
    <div class="section">
        <div class="label">Foto Bukti Penyelesaian:</div>
        <div class="photo-container">
            @foreach ($proofPhotos as $photo)
            <img src="{{ asset('storage/' . $photo) }}" alt="Foto Bukti">
            @endforeach
        </div>
    </div>
    @endif

    @endif

    <!-- <div class="section signature">
        <p>Hormat Kami,</p>
        <p>Admin Pengaduan</p>
    </div> -->
</body>

</html>