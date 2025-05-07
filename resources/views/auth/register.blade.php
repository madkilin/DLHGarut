<!doctype html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen flex items-center justify-center px-4">

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

          <!-- Baris 1: Nama dan NIK -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
              <input type="text" id="name" name="name" required
                class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
            </div>
            <div>
              <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
              <input type="text" id="nik" name="nik" pattern="\d{16}" minlength="16" maxlength="16" required
                class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
            </div>
          </div>

          <!-- Baris 2: Alamat -->
          <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
            <input type="text" id="address" name="address" required
              class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
          </div>

          <!-- Baris 3: Kontak dan Akun -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <div class="space-y-6">
              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" pattern="\d{10,13}" minlength="10" maxlength="13" required
                  class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                  class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
              </div>
            </div>

            <div class="space-y-6">
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                  class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
              </div>
              <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                  class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
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

</html>
