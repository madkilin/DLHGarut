<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Penugasan Penanganan Pengaduan</title>
    <style>
        body {
            font-family: 'Times New Roman';
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

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button onclick="window.print()">Cetak Surat Penugasan</button>

    <div class="header">
        <h1>Surat Penugasan Penanganan Pengaduan</h1>
        <p>Nomor: 002/SP/{{ date('Y') }}</p>
    </div>

    <div class="section">
        <p>Dengan ini menugaskan kepada petugas berikut:</p>
        <div class="label">Nama Petugas:</div>
        <div>{{ $complaint->assignedUser->name ?? 'Belum ditugaskan' }}</div>
        <div class="label">Email:</div>
        <div>{{ $complaint->assignedUser->email ?? '-' }}</div>
        <div class="label">Tanggal Penugasan:</div>
        <div>{{ \Carbon\Carbon::now()->format('d F Y') }}</div>
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
        <div class="label">Lokasi Pengaduan:</div>
        <div>Koordinat: {{ $complaint->latitude }}, {{ $complaint->longitude }}</div>
        <div>{{ $complaint->kabupaten }}, {{ $complaint->kecamatan }}</div>
        <div>{{ $complaint->full_address }}</div>
    </div>

    <div class="section">
        <p>Petugas diminta untuk menindaklanjuti laporan pengaduan masyarakat sebagaimana tercantum di atas dengan segera dan melaporkan hasilnya kepada admin pengaduan.</p>
    </div>

    <div class="section" style="margin-top: 3em;">
        <p>Demikian surat penugasan ini dibuat untuk dilaksanakan sebagaimana mestinya.</p>
    </div>

    <div class="section signature" style="margin-top: 3em;">
        <p>Hormat Kami,</p>
        <p style="margin-top: 4em;">Admin Pengaduan</p>
    </div>
</body>

</html>
