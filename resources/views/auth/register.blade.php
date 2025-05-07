<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen flex items-center justify-center">

  <div class="flex flex-col md:flex-row bg-[#007546]/90 shadow-xl rounded-lg overflow-hidden max-w-4xl w-full">

    <!-- Gambar -->
    <div class="md:w-1/2 w-full">
      <img src="https://via.placeholder.com/600x400" alt="Login Image" class="object-cover w-full h-64 md:h-full" />
    </div>

    <!-- Form register -->
    <div class="md:w-1/2 w-full p-8 flex flex-col justify-center">
      <h2 class="text-2xl font-bold mb-6 text-white text-center">Registrasi Akun Anda</h2>
      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
          <label for="name" class="block text-sm font-medium text-white-700">name</label>
          <input type="text" id="name" name="name" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025]"/>
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-white-700">Email</label>
          <input type="email" id="email" name="email" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025]" />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-white-700">Password</label>
          <input type="password" id="password" name="password" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025]" />
        </div>
        <div>
  <label for="password_confirmation">Konfirmasi Password</label>
  <input type="password" id="password_confirmation" name="password_confirmation" required  class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025]"/>
</div>
        <button type="submit" class="w-full bg-[#F17025] text-white py-2 rounded-md hover:bg-[#f17025c3] transition duration-300">
          Register
        </button>
      </form>
      <p class="mt-4 text-sm text-center text-white">
        sudah punya akun? <a href="{{ route('login') }}" class="text-[#F17025] hover:underline">login</a>
      </p>
    </div>

  </div>

</body>
