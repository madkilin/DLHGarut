<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-green-100 via-green-200 to-green-100 min-h-screen flex items-center justify-center px-4">

    <div class="bg-white/90 shadow-2xl rounded-2xl overflow-hidden w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center mb-6 text-[#007546]">Lupa Password</h2>

        <form id="forgotForm" onsubmit="sendToWhatsApp(event)" class="space-y-5">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" id="nama" name="nama" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300 text-gray-700" />
            </div>
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                <input type="text" id="nik" name="nik" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300 text-gray-700" />
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300 text-gray-700" />
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
                <input type="text" id="phone" name="phone" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300 text-gray-700" />
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="text" id="password" name="password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F17025] transition duration-300 text-gray-700" />
            </div>
            <button type="submit"
                class="w-full bg-gradient-to-r from-[#F17025] to-[#f19045] text-white py-3 rounded-lg shadow-md hover:opacity-90 transition duration-300">
                Kirim via WhatsApp
            </button>
        </form>
        <p class="mt-6 text-sm text-center text-black">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-[#F17025] hover:underline">Login</a>
        </p>
    </div>

    <script>
        function sendToWhatsApp(event) {
            event.preventDefault();

            let nama = document.getElementById("nama").value.trim();
            let nik = document.getElementById("nik").value.trim();
            let email = document.getElementById("email").value.trim();
            let phoneUser = document.getElementById("phone").value.trim();
            let password = document.getElementById("password").value.trim();

            if (!nama || !nik || !email || !phoneUser || !password) {
                alert("Harap lengkapi semua field.");
                return;
            }

            // Nomor admin (ganti sesuai kebutuhan)
            let phone = "6282130939820";

            // Format pesan WhatsApp
            let message = `Saya melupakan password akun saya.\n\nBerikut data saya:\n\nNama: ${nama}\nNIK: ${nik}\nEmail: ${email}\nNo Telepon: ${phoneUser}\nPassword Baru: ${password}\n\nMohon bantuannya untuk mengganti password.`;

            // Redirect ke WhatsApp
            window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, "_blank");
        }
    </script>
</body>

</html>