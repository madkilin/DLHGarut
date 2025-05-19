@extends('layout.app')

@section('style')
<script src="https://unpkg.com/feather-icons"></script>
@endsection

@section('content')
<section class="py-16 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 bg-white shadow-lg rounded-3xl py-8">
        <h1 class="text-3xl font-bold mb-10 text-center text-green-700">Dashboard Petugas</h1>

        {{-- Widget Ringkas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 text-black">
            @php
                $widgets = [
                    ['label' => 'Total Tugas', 'key' => 'total', 'icon' => 'folder', 'color' => 'bg-blue-100', 'text' => 'text-blue-600'],
                    ['label' => 'Sedang Diproses', 'key' => 'diproses', 'icon' => 'loader', 'color' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
                    ['label' => 'Selesai', 'key' => 'selesai', 'icon' => 'check-circle', 'color' => 'bg-green-100', 'text' => 'text-green-600'],
                ];
            @endphp

            @foreach ($widgets as $widget)
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
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Distribusi Status Tugas</h3>
                <canvas id="complaintPieChart" width="250" height="250"></canvas>
            </div>
        </div>
    </div>
</section>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    feather.replace();

    new Chart(document.getElementById('complaintPieChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Diproses', 'Selesai'],
            datasets: [{
                data: [{{ $complaintCounts['diproses'] }}, {{ $complaintCounts['selesai'] }}],
                backgroundColor: ['#facc15', '#4ade80']
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
