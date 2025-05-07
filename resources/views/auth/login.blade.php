<!doctype html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen flex items-center justify-center px-4">

  <div class="flex flex-col md:flex-row bg-white/90 shadow-2xl rounded-2xl overflow-hidden w-full max-w-4xl">

    <!-- Gambar -->
    <div class="md:w-1/2 w-full h-64 md:h-auto">
      <img src="{{ asset('build/assets/ilstrasi aja.webp') }}" alt="Login Image"
        class="object-cover w-full h-full" />
    </div>

    <!-- Form Login -->
    <div class="md:w-1/2 w-full flex flex-col justify-center bg-[#007546]/90 px-6 py-10 sm:px-8">

      <h2 class="text-2xl md:text-3xl font-bold mb-6 text-white text-center">Login ke Akun Anda</h2>

      <div class="bg-white rounded-lg shadow-md p-6 space-y-6 text-black">

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
          @csrf

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="email" name="email" required
              class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" id="password" name="password" required
              class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300" />
          </div>

          <button type="submit"
            class="w-full bg-gradient-to-r from-[#F17025] to-[#f19045] text-white py-3 rounded-lg shadow-md hover:opacity-90 transition duration-300">
            Login
          </button>
        </form>

      </div>

      <p class="mt-6 text-sm text-center text-white">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-[#F17025] hover:underline">Daftar</a>
      </p>

    </div>

  </div>

</body>

</html>
