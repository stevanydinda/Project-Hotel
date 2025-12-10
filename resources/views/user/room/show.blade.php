{{-- resources/views/user/room/show.blade.php --}}
@extends('template.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('user.jenis_kamar') }}" class="text-blue-600 hover:text-blue-800">
                ← Kembali ke Jenis Kamar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Room Image -->
            <div>
                @if ($room->image)
                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}"
                        class="w-full h-96 object-cover rounded-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
            </div>

            <!-- Room Details -->
            <div>
                <h1 class="text-3xl font-bold mb-4">{{ $room->name }}</h1>

                <p class="text-gray-600 mb-6">{{ $room->deskripsi ?? 'Kamar nyaman untuk menginap.' }}</p>

                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <span class="text-gray-600 w-32">Kapasitas:</span>
                        <span class="font-semibold">{{ $room->kapasitas }} orang</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <span class="text-gray-600 w-32">Stok:</span>
                        <span
                            class="font-semibold {{ $room->jumlah_kamar ?? 0 > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $room->jumlah_kamar }} kamar
                        </span>
                    </div>
                    <div class="flex items-center mb-6">
                        <span class="text-gray-600 w-32">Harga:</span>
                        <span class="text-2xl font-bold text-blue-700">
                            Rp {{ number_format($room->price ?? ($room->harga ?? 0), 0, ',', '.') }}/malam
                        </span>
                    </div>
                </div>

                <!-- Booking Button -->
                <div class="space-y-4">
                    @if (($room->jumlah_kamar ?? 0) > 0)
                        <a href="{{ route('user.kamar.booking', $room->id) }}"
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Booking Sekarang
                        </a>
                    @else
                        <button disabled
                            class="block w-full bg-gray-400 text-white font-bold py-3 px-4 rounded-lg text-center">
                            Kamar Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
