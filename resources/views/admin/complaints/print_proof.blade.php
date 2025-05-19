<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pengiriman</title>
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
    <button onclick="window.print()">Cetak Bukti</button>
    <div class="header">
        <h1>Bukti Pengiriman</h1>
    </div>

    <div class="section">
        <div class="label">Judul Pengaduan:</div>
        <div>{{ $complaint->title }}</div>
    </div>
    <div class="section">
        <div class="label">Catatan:</div>
        <div>{{ $complaint->proof->description }}</div>
    </div>
    <div class="section">
        <div class="label">Petugas:</div>
        <div>{{ implode(', ', $complaint->proof->officers ?? []) }}</div>
    </div>

    @if ($complaint->proof->photos && count($complaint->proof->photos) > 0)
        <div class="section">
            <div class="label">Foto Bukti Pengiriman:</div>
            <div class="photo-container">
                @foreach ($complaint->proof->photos as $photo)
                    <img src="{{ asset('storage/' . $photo) }}" alt="Foto Bukti">
                @endforeach
            </div>
        </div>
    @endif
</body>

</html>
