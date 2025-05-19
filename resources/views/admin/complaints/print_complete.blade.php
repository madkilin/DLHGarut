<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dokumen Lengkap Pengaduan</title>
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
    <button onclick="window.print()">Cetak Seluruh Data</button>

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
        <div class="section">
            <hr>
            <div class="label">Bukti Pengiriman</div>
        </div>
        <div class="section">
            <div class="label">Catatan:</div>
            <div>{{ $complaint->proof->description }}</div>
        </div>
        <div class="section">
            <div class="label">Petugas:</div>
            <div>{{ implode(', ', $complaint->proof->officers ?? []) }}</div>
        </div>

        @php
            $proofPhotos = is_array($complaint->proof->photos ?? [])
                ? $complaint->proof->photos
                : json_decode($complaint->proof->photos ?? '[]', true);
        @endphp

        @if (!empty($proofPhotos))
            <div class="section">
                <div class="label">Foto Bukti Pengiriman:</div>
                <div class="photo-container">
                    @foreach ($proofPhotos as $photo)
                        <img src="{{ asset('storage/' . $photo) }}" alt="Foto Bukti">
                    @endforeach
                </div>
            </div>
        @endif

    @endif

    <div class="section signature">
        <p>Hormat Kami,</p>
        <p>Admin Pengaduan</p>
    </div>
</body>

</html>
