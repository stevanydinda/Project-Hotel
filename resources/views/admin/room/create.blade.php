@extends('template.app')

@section('content')
    <div class="w-full max-w-2xl mx-auto my-10 px-4">

        {{-- Breadcrumb --}}
        <nav class="text-sm mb-6">
            <ol class="list-reset flex text-gray-600 space-x-2">
                <li>
                    <a href="#" class="hover:underline text-yellow-600">Pengguna</a>
                </li>
                <li>/</li>
                <li>
                    <a href="#" class="hover:underline text-yellow-600">Data</a>
                </li>
                <li>/</li>
                <li class="text-gray-500">Tambah</li>
            </ol>
        </nav>

        {{-- Card --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-center text-xl font-semibold mb-6 text-gray-800">Tambah Data Kamar</h2>

            <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Nama Kamar --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kamar</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kapasitas --}}
                <div class="mb-4">
                    <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                    <input type="kapasitas" id="kapasitas" name="kapasitas"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>

                {{-- Image kamar --}}
                <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="image">
                    <button type="submit"></button>


                {{-- Tombol Aksi --}}
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.rooms.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-md transition">
                        ← Kembali
                    </a>

                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-md transition">
                        Tambah Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
