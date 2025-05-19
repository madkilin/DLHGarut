<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pengaduan</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
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
    <button onclick="window.print()">Cetak Surat</button>

    <div class="header">
        <h1>Surat Pengaduan Masyarakat</h1>
        <p>Nomor Surat: 001/SPM/{{ date('Y') }}</p>
    </div>

    <div class="section">
        <div class="label">Nama Pengirim:</div>
        <div>{{ $complaint->user->name }}</div>
    </div>

    <div class="section">
        <div class="label">Judul Pengaduan:</div>
        <div>{{ $complaint->title }}</div>
    </div>

    <div class="section">
        <div class="label">Deskripsi:</div>
        <div>{!! $complaint->description !!}</div>
    </div>

    <div class="section">
        <div class="label">Lokasi:</div>
        <div>{{ $complaint->latitude }}, {{ $complaint->longitude }}</div>
        <div>{{ $complaint->kabupaten }}, {{ $complaint->kecamatan }}</div>
        <div>{{ $complaint->full_address }}</div>
    </div>

    @if ($complaint->photos && count(json_decode($complaint->photos)) > 0)
        <div class="section">
            <div class="label">Foto Pengaduan:</div>
            <div class="photo-container">
                @foreach (json_decode($complaint->photos) as $photo)
                    <img src="{{ storage_path('app/public/' . $photo) }}" alt="Foto Pengaduan">
                @endforeach
            </div>
        </div>
    @endif

    <div class="signature">
        <p>Hormat Kami,</p>
        <p>Admin Pengaduan</p>
    </div>
</body>

</html>
