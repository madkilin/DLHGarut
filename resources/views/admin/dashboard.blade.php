@extends('layout.app')

@section('style')
<script src="https://unpkg.com/feather-icons"></script>
@endsection

@section('content')
<section class="py-16 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 bg-white shadow-lg rounded-3xl py-8">
        <h1 class="text-3xl font-bold mb-10 text-center text-green-700">Dashboard Admin</h1>

       {{-- Widget: User Overview --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10 text-black">
    @php
        $userWidgets = [
            ['label' => 'Total User', 'value' => $totalUsers, 'icon' => 'users', 'color' => 'bg-green-100', 'text' => 'text-green-600'],
            ['label' => 'Total Petugas', 'value' => $totalPetugas, 'icon' => 'user-check', 'color' => 'bg-blue-100', 'text' => 'text-blue-600'],
        ];
    @endphp

    @foreach ($userWidgets as $widget)
        <div class="{{ $widget['color'] }} p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="{{ $widget['text'] }}">
                    <i data-feather="{{ $widget['icon'] }}" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-sm font-medium">{{ $widget['label'] }}</p>
                    <p class="text-2xl font-bold">{{ $widget['value'] }}</p>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Total Masyarakat with active & nonactive --}}
    <div class="bg-yellow-100 p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300">
        <div class="flex items-center gap-4 mb-2">
            <div class="text-yellow-600">
                <i data-feather="user" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-sm font-medium">Total Masyarakat</p>
                <p class="text-2xl font-bold">{{ $totalMasyarakat }}</p>
            </div>
        </div>
        <div class="text-sm text-gray-700 ml-11">
            <p>Aktif: <span class="font-semibold">{{ $masyarakatAktif }}</span></p>
            <p>Nonaktif: <span class="font-semibold">{{ $masyarakatNonaktif }}</span></p>
        </div>
    </div>

    {{-- Pie Chart --}}
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300 flex justify-center items-center">
        <canvas id="userPieChart" width="120" height="120"></canvas>
    </div>
</div>


        {{-- Widget: Complaint Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-10 text-black">
            @php
                $complaintWidgets = [
                    ['label' => 'Terkirim', 'key' => 'terkirim', 'icon' => 'send', 'color' => 'bg-gray-100', 'text' => 'text-gray-700'],
                    ['label' => 'Diterima', 'key' => 'diterima', 'icon' => 'inbox', 'color' => 'bg-green-100', 'text' => 'text-green-600'],
                    ['label' => 'Diproses', 'key' => 'diproses', 'icon' => 'loader', 'color' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
                    ['label' => 'Ditolak', 'key' => 'ditolak', 'icon' => 'x-circle', 'color' => 'bg-red-100', 'text' => 'text-red-600'],
                    ['label' => 'Selesai', 'key' => 'selesai', 'icon' => 'check-circle', 'color' => 'bg-blue-100', 'text' => 'text-blue-600'],
                ];
            @endphp

            @foreach ($complaintWidgets as $widget)
                <div class="{{ $widget['color'] }} p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="{{ $widget['text'] }}">
                            <i data-feather="{{ $widget['icon'] }}" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ $widget['label'] }}</p>
                            <p class="text-2xl font-bold">{{ $complaintCounts[$widget['key']] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pie Chart --}}
        <div class="bg-white p-6 rounded-xl shadow text-black flex justify-center">
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Distribusi Status Pengaduan</h3>
                <canvas id="complaintPieChart" width="250" height="250"></canvas>
            </div>
        </div>
    </div>
</section>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    feather.replace();

    new Chart(document.getElementById('userPieChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Petugas', 'Masyarakat'],
            datasets: [{
                data: [{{ $totalPetugas }}, {{ $totalMasyarakat }}],
                backgroundColor: ['#3b82f6', '#facc15'],
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    new Chart(document.getElementById('complaintPieChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Terkirim', 'Diterima', 'Diproses', 'Ditolak', 'Selesai'],
            datasets: [{
                data: [
                    {{ $complaintCounts['terkirim'] }},
                    {{ $complaintCounts['diterima'] }},
                    {{ $complaintCounts['diproses'] }},
                    {{ $complaintCounts['ditolak'] }},
                    {{ $complaintCounts['selesai'] }}
                ],
                backgroundColor: ['#d1d5db', '#4ade80', '#facc15', '#f87171', '#60a5fa']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endsection
