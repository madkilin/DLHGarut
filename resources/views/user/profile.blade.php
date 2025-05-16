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
        $level = \App\Models\Level::where('level', $user->level)->first();
        $maxExp = $level ? $level->required_exp : 0;
        $progress = $maxExp > 0 ? ($user->exp / $maxExp) * 100 : 0;
    @endphp

    <section class="py-20 bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen">
        @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-4xl mx-auto mt-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-4xl mx-auto mt-4" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-2xl p-8">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-4 sm:space-y-0">
                    <img src="{{ asset('storage/profile_photos/' . $user->profile_photo ?? 'default_image/default_profile.jpg') }}" alt="User Profile"
                        class="w-28 h-28 rounded-full shadow-md border-4 border-green-200 mx-auto sm:mx-0">
                    <div class="text-center mx-3 sm:text-left">
                        <h2 class="text-3xl font-bold text-[#F17025]">{{ $user->name }}</h2>
                        <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500 mt-1">Anggota sejak Januari 2023</p>
                    </div>
                    <div class="flex-1 mx-auto">
                        <p class="text-xs text-gray-600 text-center sm:text-left">Level: {{ $user->level }} | Points:
                            {{ $user->points }}
                            <a href="javascript:void(0);" onclick="openModal('swapPointsModal')"
                                class="inline-block bg-[#F17025] hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-full transition-all duration-300 shadow-md mt-2 sm:mt-0">
                                TukarPoint
                            </a>
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-[#007546] h-2 rounded-full" style="width: {{ $progress }}%;"></div>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-1 text-center sm:text-left">{{ $user->exp }} /
                            {{ $maxExp }} EXP</p>
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="text-lg font-semibold text-gray-700">Statistik</h3>
                    <ul class="mt-2 text-gray-600">
                        <li>- Total Artikel Dibaca: <strong>42</strong></li>
                        <li>- Peringkat di Leaderboard: <strong>#7</strong></li>
                    </ul>
                </div>

                <!-- Badges -->
                <div class="container mx-auto px-4 py-10">
                    <h2 class="text-2xl font-bold my-3 text-center">Kumpulan Badge Saya</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @php
                            $badges = [
                                ['name' => 'Badge Explorer', 'unlocked' => true, 'progress' => 100, 'points' => 0],
                                ['name' => 'Top Contributor', 'unlocked' => false, 'progress' => 70, 'points' => 0],
                                ['name' => 'Poin Enthusiast', 'unlocked' => false, 'progress' => 0, 'points' => 120],
                                ['name' => 'Poin Enthusiast', 'unlocked' => false, 'progress' => 0, 'points' => 120],
                                ['name' => 'Poin expert', 'unlocked' => false, 'progress' => 0, 'points' => 130],
                                ['name' => 'Community Hero', 'unlocked' => true, 'progress' => 100, 'points' => 0],
                            ];
                        @endphp
                        @foreach ($badges as $badge)
                            @if (!$badge['points'] > 0)
                                <div class="bg-white rounded-xl shadow-md p-4 text-center relative group">
                                    <div class="flex justify-center mb-3">
                                        <div class="relative">
                                            <img src="{{ asset('build/assets/channels4_profile.jpg') }}"
                                                class="w-20 h-20 rounded-full border-4 border-gray-200 object-cover @if (!$badge['unlocked']) grayscale @endif badge-icon"
                                                alt="Badge Image"
                                                data-tooltip="{{ $badge['unlocked'] ? 'Badge telah diperoleh' : ($badge['points'] > 0 ? 'Dapat ditukar dengan poin' : 'Belum selesai') }}">
                                            <span
                                                class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                                                {{ $badge['unlocked'] ? '✔' : '?' }}
                                            </span>
                                        </div>
                                    </div>
                                    <h3 class="font-semibold text-lg mb-2 text-[#F17025]">{{ $badge['name'] }}</h3>
                                    @if ($badge['unlocked'])
                                        <p class="text-green-600 font-medium">Telah Diperoleh</p>
                                    @else
                                        <div class="text-sm text-gray-600 mb-2">Progress</div>
                                        <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                                            <div class="bg-blue-500 h-3 rounded-full"
                                                style="width: {{ $badge['progress'] }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500">{{ $badge['progress'] }}%</p>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-8 text-center">
                    <a href="javascript:void(0);" onclick="openModal('editProfileModal')"
                        class="inline-block bg-[#F17025] hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-full transition-all duration-300 shadow-md">
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal Edit Profil -->
        <div id="editProfileModal"
            class="fixed inset-0 bg-black bg-opacity-10 flex items-center justify-center z-50 hidden p-3 my-3">
            <div class="bg-white w-full max-w-lg rounded-xl p-6 relative shadow-lg max-h-screen overflow-y-auto">
                <h2 class="text-2xl font-bold mb-4 text-[#F17025]">Edit Profil</h2>

                <!-- Form Edit -->
                <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="text-black">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-black">Nama</label>
                        <input type="text" name="name" class="w-full border border-gray-300 rounded p-2" value="{{ old('name', Auth::user()->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-black">Email</label>
                        <input type="email" name="email" class="w-full border border-gray-300 rounded p-2" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-black">Password</label>
                        <input type="password" name="password" class="w-full border border-gray-300 rounded p-2" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                    </div>

                    <div class="mb-4">
                        <label class="block text-black">Alamat</label>
                        <textarea name="address" class="w-full border border-gray-300 rounded p-2" rows="2"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-black">Foto Profil</label>
                        <div class="flex flex-col items-center justify-center border border-gray-300 rounded p-4">
                            <!-- Preview -->
                            <img id="profileImagePreview" src="" alt="Preview"
                                class="w-24 h-24 rounded-full object-cover border mb-2 hidden" />

                            <!-- Input -->
                            <input type="file" accept="image/*" id="profileImageInput" class="text-center" name="profile_photo"/>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="button" onclick="closeModal('editProfileModal')"
                            class="mr-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-[#F17025] text-white rounded hover:bg-orange-600 transition">Simpan</button>
                    </div>
                </form>

                <!-- Close Icon -->
                <button onclick="closeModal('editProfileModal')"
                    class="absolute top-2 right-4 text-gray-500 hover:text-black text-2xl">&times;</button>
            </div>
        </div>

        {{-- modal badge --}}
        <div id="swapPointsModal"
            class="fixed inset-0 bg-black bg-opacity-10 flex items-center justify-center z-50 hidden p-3 my-3">
            <div class="bg-white w-full max-w-4xl rounded-xl p-6 relative shadow-lg max-h-screen overflow-y-auto">
                <h2 class="text-2xl font-bold mb-4 text-[#F17025] text-center   ">Swap Point</h2>
                <h2 class="text-2xl font-bold mb-4 text-[#F17025]">badge</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 my-3">
                    @foreach ($badges as $badge)
                        @if (!$badge['unlocked'] && $badge['points'] > 0)
                            <div class="bg-white rounded-xl shadow-md p-4 text-center relative group">
                                <div class="flex justify-center mb-3">
                                    <div class="relative">
                                        <img src="{{ asset('build/assets/channels4_profile.jpg') }}"
                                            class="w-20 h-20 rounded-full border-4 border-gray-200 object-cover @if (!$badge['unlocked']) grayscale @endif price-badge-icon"
                                            alt="Badge Image"
                                            data-tooltip="{{ 'Dapat ditukar dengan poin ' . $badge['points'] }}">
                                    </div>
                                </div>
                                <h3 class="font-semibold text-lg mb-2 text-[#F17025]">{{ $badge['name'] }}</h3>
                                <p class="text-yellow-600 text-sm mb-2">Dapat dibeli dengan
                                    <strong>{{ $badge['points'] }}</strong> poin
                                </p>
                                <button
                                    class="bg-yellow-500 text-white px-3 py-1 rounded-full hover:bg-yellow-600 transition">Beli
                                    Badge</button>
                            </div>
                        @endif
                    @endforeach
                </div>
                <h2 class="text-2xl font-bold mb-4 text-[#F17025]">sertifikat</h2>
                <div class="max-w-md mx-auto bg-white rounded-xl shadow-md p-6 text-center">
                    <img src="{{ asset('build/assets/channels4_profile.jpg') }}"
                        class="w-32 h-32 mx-auto mb-4 object-cover rounded-md shadow" alt="Sertifikat">
                    <p class="text-gray-600 mb-2">Gunakan <strong>100 poin</strong> untuk mencetak sertifikat resmi
                        Anda.</p>
                    <button
                        class="bg-green-600 text-white font-semibold px-6 py-2 rounded-full hover:bg-green-700 transition">
                        Cetak Sertifikat
                    </button>
                </div>
                <!-- Close Icon -->
                <button onclick="closeModal('swapPointsModal')"
                    class="absolute top-2 right-4 text-gray-500 hover:text-black text-2xl">&times;</button>
            </div>
        </div>
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
    </script>
@endsection
