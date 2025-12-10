
@extends('template.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">Jenis Kamar di Hotel Aston</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($rooms as $room)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Room Image -->
            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}"
                     alt="{{ $room->name }}"
                     class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">No Image</span>
                </div>
            @endif

            <!-- Room Details -->
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2">{{ $room->name }}</h3>

                <div class="mb-4">
                    <p class="text-gray-600 mb-1">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        Kapasitas: {{ $room->kapasitas }} orang
                    </p>
                    <p class="text-gray-600">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4z" clip-rule="evenodd"/>
                        </svg>
                        Stok: {{ $room->jumlah_kamar }} kamar
                    </p>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <p class="text-2xl font-bold text-blue-700">
                        Rp {{ number_format($room->price ?? $room->harga ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-500">per malam</p>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-2">
                    <a href="{{ route('user.kamar.show', $room->id) }}"
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded">
                        Lihat Detail
                    </a>

                    @if(($room->jumlah_kamar ?? 0) > 0)
                    <a href="{{ route('user.kamar.booking', $room->id) }}"
                       class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded">
                        Booking
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
