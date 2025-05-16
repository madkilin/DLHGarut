<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
</head>

<body
    class="bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen flex items-center justify-center px-4">

    <div class="flex flex-col md:flex-row bg-[#007546]/90 shadow-xl rounded-2xl overflow-hidden w-full max-w-5xl my-4">

        <!-- Gambar -->
        <div class="md:w-1/3 w-full h-64 md:h-auto">
            <img src="{{ asset('build/assets/ilstrasi aja.webp') }}" alt="Login Image"
                class="object-cover w-full h-full" />
        </div>

        <!-- Form register -->
        <div class="md:w-2/3 w-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 text-white text-center">Registrasi Akun Anda</h2>
            <div class="bg-white rounded-lg shadow-md p-6 text-black space-y-6">

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-md mx-auto mt-4"
                            role="alert">
                            <strong class="font-bold">Registrasi gagal!</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Baris 1: Nama dan NIK -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
                        </div>
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" id="nik" name="nik" pattern="\d{16}" minlength="16"
                                maxlength="16" value="{{ old('nik') }}" required
                                class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
                        </div>
                    </div>

                    <!-- Baris 2: Alamat -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}" required
                            class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
                    </div>

                    <!-- Baris 3: Kontak dan Akun -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="space-y-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor
                                    Telepon</label>
                                <input type="text" id="phone" name="phone" pattern="\d{10,13}" minlength="10"
                                    maxlength="13" value="{{ old('phone') }}" required
                                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="relative">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" id="password" name="password" required
                                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300 pr-10" />
                                <button type="button" onclick="togglePassword('password', this)"
                                    class="absolute inset-y-0 right-3 flex items-center text-sm text-gray-600 mt-8">
                                    👁️
                                </button>
                            </div>
                            <div class="relative">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300 pr-10" />
                                <button type="button" onclick="togglePassword('password_confirmation', this)"
                                    class="absolute inset-y-0 right-3 flex items-center text-sm text-gray-600 mt-8">
                                    👁️
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div>
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-[#F17025] to-[#f19045] text-white py-3 rounded-lg shadow-md hover:opacity-90 transition duration-300">
                            Register
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-6 text-sm text-center text-white">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-[#F17025] hover:underline">Login</a>
            </p>
        </div>

    </div>

</body>
<script>
    function togglePassword(fieldId, toggleBtn) {
        const input = document.getElementById(fieldId);
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);

        // Optional: Ganti ikon tombol
        toggleBtn.textContent = type === 'password' ? '👁️' : '🙈';
    }
</script>

</html>
