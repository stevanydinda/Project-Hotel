@extends('template.app')

@section('content')
    <div class="w-full max-w-2xl mx-auto my-10 px-4">


        {{-- Card --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-center text-xl font-semibold mb-6 text-gray-800">Edit Data Kamar</h2>

            <form method="POST" action="{{ route('admin.rooms.update', $room->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nama Kamar --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kamar</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $room->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Tipe Kamar --}}
                <div class="mb-4">
                    <label for="tipe_kamar" class="block text-sm font-medium text-gray-700 mb-1">Tipe Kamar</label>
                    <input type="text" id="tipe_kamar" name="tipe_kamar"
                        value="{{ old('tipe_kamar', $room->tipe_kamar) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    @error('tipe_kamar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Jumlah Kamar --}}
                <div class="mb-4">
                    <label for="jumlah_kamar" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Kamar</label>
                    <input type="number" id="jumlah_kamar" name="jumlah_kamar"
                        value="{{ old('jumlah_kamar', $room->jumlah_kamar) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    @error('jumlah_kamar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md">{{ old('deskripsi', $room->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga Kamar (Rp)</label>
                    <input type="number" id="harga" name="harga" value="{{ old('harga', $room->harga) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>


                {{-- Kapasitas --}}
                <div class="mb-4">
                    <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                    <input type="number" id="kapasitas" name="kapasitas" value="{{ old('kapasitas', $room->kapasitas) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>


                {{-- Gambar Kamar --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Kamar</label>

                    {{-- Preview Gambar Lama --}}
                    @if ($room->image)
                        <img src="{{ asset('storage/rooms/' . $room->image) }}"
                            class="w-32 h-32 object-cover rounded mb-2 border">
                    @endif

                    <input type="file" name="image"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <p class="text-gray-500 text-sm mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('admin.rooms.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-md transition">
                        ← Kembali
                    </a>

                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-md transition">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
