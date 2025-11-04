<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DLH Garut | Register</title>
    <link rel="icon" href="{{ asset('default_image/logo.jpg') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // 🔥 SweetAlert dari Laravel (validasi server & pesan sukses)
        document.addEventListener('DOMContentLoaded', function() {
            @if($errors - > any())
            let errorMessages = `
                <ul style="text-align:left; list-style-type:disc; margin-left:20px;">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            `;
            Swal.fire({
                icon: 'error',
                title: 'Registrasi gagal!',
                html: errorMessages,
                confirmButtonColor: '#F17025'
            });
            @endif

            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil!',
                text: '{{ session('
                success ') }}',
                confirmButtonColor: '#F17025'
            });
            @endif
        });
    </script>
</head>

<body
    class="bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen flex items-center justify-center px-4">

    <div class="flex flex-col md:flex-row bg-[#007546]/90 shadow-xl rounded-2xl overflow-hidden w-full max-w-3xl my-4 justify-center p-[10px]">

        <!-- Form register -->
        <div class="md:w-3xl w-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 text-white text-center">Registrasi Akun Anda</h2>
            <div class="bg-white rounded-lg shadow-md p-6 text-black space-y-6">

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    <!-- Baris 1: Nama dan NIK -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap"
                                class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
                        </div>
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" id="nik" name="nik" pattern="\d{16}" minlength="16"
                                maxlength="16" value="{{ old('nik') }}" required placeholder="Nik 16 angka"
                                class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
                        </div>
                    </div>

                    <!-- Baris 2: Alamat -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}" required placeholder="Alamat Lengkap"
                            class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
                    </div>

                    <!-- Baris 3: Kontak dan Akun -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="space-y-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor
                                    Telepon</label>
                                <input type="text" id="phone" name="phone" pattern="\d{10,13}" minlength="10"
                                    maxlength="13" value="{{ old('phone') }}" required placeholder="Nomor Telepon Dengan 10-13 angka"
                                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email"
                                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="relative">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" id="password" name="password" required placeholder="password dengan 6 char"
                                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300 pr-10" />
                                <button type="button" onclick="togglePassword('password', this)"
                                    class="absolute inset-y-0 right-3 flex items-center text-sm text-gray-600 mt-8">
                                    👁️
                                </button>
                            </div>
                            <div class="relative">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="isi kembali password"
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
        toggleBtn.textContent = type === 'password' ? '👁️' : '🙈';
    }

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

    // Validasi sebelum submit (client-side)
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = ['name', 'nik', 'address', 'phone', 'email', 'password', 'password_confirmation'];
        let valid = true;

        requiredFields.forEach(id => {
            const input = document.getElementById(id);
            if (!input.value.trim()) {
                valid = false;
            }
        });

        if (!valid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Data belum lengkap!',
                text: 'Mohon lengkapi semua kolom sebelum melanjutkan.',
                confirmButtonColor: '#F17025'
            });
        } else {
            // Cek apakah password dan konfirmasi password sama
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            if (pass !== confirm) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Password tidak sama!',
                    text: 'Pastikan konfirmasi password sesuai dengan password yang kamu buat.',
                    confirmButtonColor: '#F17025'
                });
            }
        }
    });
</script>

</html>