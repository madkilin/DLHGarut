<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Laporan Pengaduan Masyarakat</title>
    <style>
        body {
            font-family: sans-serif;
            /* font-family: 'Times New Roman', Times, serif; */
            margin: 2cm;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 2em;
        }

        .header h1 {
            margin: 0;
        }

        .letter-number {
            margin-bottom: 1em;
        }

        .section {
            margin-bottom: 1.5em;
        }

        .label {
            font-weight: bold;
        }

        .photo-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .photo-container img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #ccc;
        }

        .signature {
            margin-top: 3em;
            text-align: right;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button onclick="window.print()">Cetak Detail Laporan</button>

    <div class="header">
        <h1>Detail Laporan Pengaduan Masyarakat</h1>
        <!-- <p>Nomor Surat: 001/SPM/{{ date('Y') }}</p> -->
        <!-- <p>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p> -->
    </div>

    <!-- <div class="section">
        <div class="label">Status Pengaduan:</div>
        <div>{{ $complaint->status }}</div>
    </div> -->

    <div class="section">
        <div class="label">Nama Pengirim:</div>
        <div>{{ $complaint->user->name }}</div>
    </div>
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
        <div class="label">Lokasi:</div>
        <br>
        <div>Link: <a href="https://www.google.com/maps?q={{ $complaint->latitude }},{{ $complaint->longitude }}" target="_blank">
                https://www.google.com/maps?q={{ $complaint->latitude }},{{ $complaint->longitude }} </a>
        </div>
        <div>Koordinat: {{ $complaint->latitude }}, {{ $complaint->longitude }}</div>
        <div>{{ $complaint->kabupaten }}, {{ $complaint->kecamatan }}</div>
        <div>{{ $complaint->full_address }}</div>
    </div>

    @if ($complaint->photos && count(json_decode($complaint->photos)) > 0)
    <div class="section">
        <div class="label">Foto Pengaduan:</div>
        <div class="photo-container">
            @foreach (json_decode($complaint->photos) as $photo)
            <img src="{{ Storage::url($photo) }}" class="h-24 w-24 object-cover rounded shadow">
            @endforeach
        </div>
    </div>
    @endif

    <!-- @if ($complaint->video)
    <div class="section">
        <strong>Video Pengaduan:</strong><br>
        <a href="{{ Storage::url($complaint->video) }}" target="_blank">
            Klik untuk melihat video
        </a>
    </div>
    @endif -->

    <!-- <div class="signature">
        <p>Hormat Kami,</p>
        <p>Admin Pengaduan</p>
    </div> -->
</body>

</html>