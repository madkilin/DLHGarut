@extends('layout.app')

@section('style')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .tooltip {
        position: absolute;
        top: -10px;
        left: 100%;
        margin-left: 10px;
        background-color: #333;
        color: #fff;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 50;
        display: none;
    }

    /* Modal overlay */
    #editProfileModal,
    #swapPointsModal {
        background-color: rgba(0, 0, 0, 0.5);
    }

    @media (max-width: 640px) {
        .tooltip {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
@php
$user = Auth::user();

$currentLevel = \App\Models\Level::where('level', $user->level)->first();
$nextLevel = \App\Models\Level::where('level', $user->level + 1)->first();

$startExp = 0; // selalu mulai dari nol di setiap level
$endExp = $nextLevel ? $nextLevel->required_exp : $startExp;

$progress = $endExp > $startExp
? (($user->exp - $startExp) / ($endExp - $startExp)) * 100
: 100;

$progress = max(0, min(100, $progress)); // jaga-jaga biar ga lewat 100%
$maxExp = $endExp;
@endphp

<section class="py-20 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-4xl mx-auto mt-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-4xl mx-auto mt-4" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-2xl p-8">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-4 sm:space-y-0">

                <div class="relative w-28 h-28 mx-auto sm:mx-0">
                    <img src="{{ asset($user->avatar) }}" alt="User Profile" class="w-28 h-28 rounded-full shadow-md {{ $user->role_id == 3 ? $user->tier_border_class : '' }}">
                    @if ($user->role_id == 3)
                    <div class="absolute -top-2 -right-2 bg-white rounded-full shadow-lg border-2 border-gray-200 w-7 h-7 flex items-center justify-center text-sm">
                        {{ $user->tier_icon }}
                    </div>
                    @endif
                </div>

                <div class="text-center mx-3 sm:text-left">
                    <h2 class="text-3xl font-bold text-[#F17025]">{{ $user->name }}</h2>
                    <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                    <p class="text-sm text-gray-500 mt-1">Anggota sejak Januari 2023</p>
                </div>
                <div class="flex-1 mx-auto">
                    @if (auth()->user()->role_id == 3)
                    <div class="flex justify-between items-center text-xs text-gray-600">
                        <span>Level: {{ $user->level }} | Points: {{ $user->points }}</span>
                        <a href="javascript:void(0);" onclick="openModal('swapPointsModal')" class="bg-[#F17025] hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-full transition-all duration-300 shadow-md">
                            Tukar Point
                        </a>
                    </div>

                    @if($user->level > 21)
                    {{-- Unlimited mode --}}
                    <div class="w-full bg-gray-200 rounded-full h-3 mt-2 overflow-hidden">
                        <div
                            class="progress-bar h-3 rounded-full transition-[width] duration-700 ease-out bg-[#007546]"
                            data-progress="100">
                        </div>
                    </div>

                    <p class="text-[10px] text-gray-500 mt-1 flex items-center gap-1">
                        {{-- Infinity symbol --}}
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none"
                            stroke="#007546" stroke-width="2"
                            class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12c0-2 2-4 4-4s4 2 4 4-2 4-4 4-4-2-4-4zm-2 0c0-3 3-6 6-6s6 3 6 6-3 6-6 6-6-3-6-6z" />
                        </svg>
                        <span class="text-[#007546] font-semibold">
                            {{ $user->exp }} / ∞ Unlimited EXP
                        </span>
                    </p>
                    @else
                    {{-- Normal exp bar --}}
                    <div class="w-full bg-gray-200 rounded-full h-3 mt-2 overflow-hidden">
                        <div
                            class="progress-bar h-3 rounded-full transition-[width] duration-700 ease-out bg-gradient-to-r from-[#007546] to-[#00a96e]"
                            data-progress="{{ $progress }}">
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1">
                        {{ $user->exp }} / {{ $maxExp }} EXP
                    </p>
                    @endif
                    @endif

                </div>
            </div>
            @if (auth()->user()->role_id == 3)
            <div class=" mt-5">
                <h3 class="text-lg font-semibold text-gray-700">Statistik</h3>
                <ul class="mt-2 text-gray-600">
                    <li>- Total Artikel Dibaca: <strong>{{ $user->readArticle->count() }}</strong></li>
                    <li>- Peringkat di Leaderboard: <strong>#{{ $user->leaderboard }}</strong></li>
                </ul>
            </div>
            <div class="mt-5">
                <h3 class="text-lg font-semibold text-gray-700">Data Profil</h3>
                <ul class="mt-2 text-gray-600">
                    <li>- NIK: <strong>{{ $user->nik }}</strong></li>
                    <li>- No.Telepon: <strong>{{ $user->phone }}</strong></li>
                    <li>- Alamat: <strong>{{ $user->address }}</strong></li>

                </ul>
            </div>
            @endif

            @php
            $badges = [['name' => 'Badge Explorer', 'unlocked' => true, 'progress' => 100, 'points' => 0], ['name' => 'Top Contributor', 'unlocked' => false, 'progress' => 70, 'points' => 0], ['name' => 'Poin Enthusiast', 'unlocked' => false, 'progress' => 0, 'points' => 120], ['name' => 'Poin Enthusiast', 'unlocked' => false, 'progress' => 0, 'points' => 120], ['name' => 'Poin expert', 'unlocked' => false, 'progress' => 0, 'points' => 130], ['name' => 'Community Hero', 'unlocked' => true, 'progress' => 100, 'points' => 0]];
            @endphp

            <!-- Action Button -->
            <div class="mt-8 text-center">
                <a href="javascript:void(0);" onclick="openModal('editProfileModal')" class="inline-block bg-[#F17025] hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-full transition-all duration-300 shadow-md">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>

    @include('user.edit-profile')
    @include('user.tukar-point')

</section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.badge-icon').hover(function(e) {
            const tooltipText = $(this).attr('data-tooltip');
            const $tooltip = $('<div class="tooltip"></div>').text(tooltipText);

            $(this).after($tooltip);
            $tooltip.fadeIn(200);
        }, function() {
            $(this).siblings('.tooltip').fadeOut(100, function() {
                $(this).remove();
            });
        });
    });
    $(document).ready(function() {
        $('.price-badge-icon').hover(function(e) {
            const tooltipText = $(this).attr('data-tooltip');
            const $tooltip = $('<div class="tooltip"></div>').text(tooltipText);

            $(this).after($tooltip);
            $tooltip.fadeIn(200);
        }, function() {
            $(this).siblings('.tooltip').fadeOut(100, function() {
                $(this).remove();
            });
        });
    });

    // script for modal
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
    // Tampilkan preview hanya jika ada gambar, jika tidak sembunyikan
    $('#profileImageInput').on('change', function(e) {
        const [file] = e.target.files;
        if (file) {
            const previewURL = URL.createObjectURL(file);
            $('#profileImagePreview')
                .attr('src', previewURL)
                .removeClass('hidden');
        } else {
            $('#profileImagePreview')
                .attr('src', '')
                .addClass('hidden');
        }
    });

    // Batasi panjang NIK
    document.getElementById('nik').addEventListener('input', function() {
        let val = this.value;

        // Hapus semua karakter selain angka
        val = val.replace(/\D/g, '');
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });

    // Batasi panjang Nomor Telepon
    document.getElementById('phone').addEventListener('input', function() {
        let val = this.value;

        // Hapus semua karakter selain angka
        val = val.replace(/\D/g, '');

        // Pastikan dimulai dengan "08"
        if (!val.startsWith('08')) {
            if (val.startsWith('8')) {
                val = '0' + val; // kalau user ngetik 8 di awal
            } else if (!val.startsWith('08')) {
                val = '08'; // kalau awalnya bukan 0/8, langsung ubah jadi 08
            }
        }

        // Batasi maksimal 13 digit
        if (val.length > 13) {
            val = val.slice(0, 13);
        }

        this.value = val;
    });
</script>
@endsection