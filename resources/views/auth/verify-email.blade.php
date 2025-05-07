    <div class="mb-4 text-sm text-gray-600">
        Sebelum lanjut, silakan verifikasi email kamu dengan link yang kami kirim.
    </div>

    @if (session('message'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn">
            Kirim ulang email verifikasi
        </button>
    </form>
