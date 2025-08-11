{{-- modal badge --}}
<div id="swapPointsModal" class="fixed inset-0 bg-black bg-opacity-10 flex items-center justify-center z-50 hidden p-3 my-3">
    <div class="bg-white w-full max-w-4xl rounded-xl p-6 relative shadow-lg max-h-screen overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4 text-[#F17025] text-center   ">Tukar Point : {{ $user->points }}</h2>
        <h2 class="text-2xl font-bold mb-4 text-[#F17025]">Reward</h2>
        <form action="{{ route('exchange-point.store') }}" method="post">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 my-3">
                @foreach ($rewards as $reward)
                    <div class="bg-white rounded-xl shadow-md p-4 text-center relative group">
                        <div class="flex justify-center mb-3">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $reward->image) }}" class="w-20 h-20 rounded-full border-4 border-gray-200 object-cover price-badge-icon" alt="Badge Image" data-tooltip="Dapat ditukar dengan {{ $reward->point }} poin">
                            </div>
                        </div>
                        <h3 class="font-semibold text-lg mb-2 text-[#F17025]">{{ $reward->name }}</h3>
                        <input type="hidden" name="reward_id" value="{{ $reward->id }}">
                        <input type="hidden" name="point" value="{{ $reward->point }}">
                        <p class="text-yellow-600 text-sm mb-2">Minimum : <strong>{{ $reward->point }}</strong> poin
                        </p>
                        @if (auth()->user()->points >= $reward->point)
                            <button type="submit" style="cursor: pointer;" class="bg-yellow-500 text-white px-3 py-1 rounded-full hover:bg-yellow-600 transition">Tukar Poin</button>
                        @else
                            <button type="button" class="bg-gray-500 text-white px-3 py-1 rounded-full">Poin tidak cukup</button>
                        @endif
                    </div>
                @endforeach
            </div>
        </form>
        <button style="cursor: pointer;" onclick="closeModal('swapPointsModal')" class="absolute top-2 right-4 text-gray-500 hover:text-black text-2xl">&times;</button>
    </div>
</div>
