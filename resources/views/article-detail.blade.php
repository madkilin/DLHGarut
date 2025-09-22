@extends('layout.app')

@section('content')
<section class="py-20 px-4 md:px-20 bg-white text-gray-800">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-bold text-[#007546] mb-6">{{ $article->title }}</h1>
        <img src="{{ asset('storage/' . $article->banner) }}" alt="{{ $article->title }}"
            class="w-full h-80 object-cover rounded-xl shadow mb-8">
        @if ($article->video)
        <div class="flex justify-center">
            <video class="w-[640px] h-[360px]" controls>
                <source src="{{ asset('storage/' . $article->video) }}" type="video/mp4">
            </video>
        </div>
        @endif
        <h5 class="text-gray-700">Author : {{ $article->user->name }} </h5>
        <h5 class="text-gray-700">Tanggal Pembuatan : {{ $article->created_at->format('d/m/Y') }} </h5>

        <p class="text-gray-700 text-base leading-relaxed whitespace-pre-line">
            {!! $article->description !!}
        </p>
        <p>Viewer : {{ $article->read->count() }}</p>

    </div>
</section>
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
            const indicator = document.createElement('div');
            indicator.style.position = 'fixed';
            indicator.style.bottom = '20px';
            indicator.style.right = '20px';
            indicator.style.backgroundColor = '#007546';
            indicator.style.color = 'white';
            indicator.style.padding = '10px 20px';
            indicator.style.borderRadius = '10px';
            indicator.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
            indicator.style.zIndex = 1000;
            indicator.innerText = 'Memeriksa status...';
            document.body.appendChild(indicator);

            fetch("{{ route('artikel.reward.check', $article->id) }}")
                .then(res => res.json())
                .then(data => {
                    if (data.claimed) {
                        indicator.innerText = 'Kamu sudah dapat reward hari ini ✅';
                        setTimeout(() => document.body.removeChild(indicator), 3000);
                    } else {
                        let timer = 15;
                        indicator.innerText = `Membaca... (${timer})`;
                        const countdown = setInterval(() => {
                            timer--;
                            indicator.innerText = `Membaca... (${timer})`;

                            if (timer <= 0) {
                                clearInterval(countdown);
                                fetch("{{ route('artikel.reward.claim', $article->id) }}", {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json',
                                            'Content-Type': 'application/json'
                                        }
                                    })
                                    .then(res => res.json())
                                    .then(result => {
                                        indicator.innerText = result.message;
                                        setTimeout(() => document.body.removeChild(indicator),
                                            3000);
                                    })
                                    .catch(() => {
                                        indicator.innerText = 'Gagal klaim reward';
                                        setTimeout(() => document.body.removeChild(indicator),
                                            3000);
                                    });
                            }
                        }, 1000);
                    }
                })
                .catch(() => {
                    indicator.innerText = 'Gagal memeriksa reward';
                    setTimeout(() => document.body.removeChild(indicator), 3000);
                });
        });
</script>
@endsection