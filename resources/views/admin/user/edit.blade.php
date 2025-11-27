@extends('template.app')

@section('content')
<div class="max-w-2xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-gray-600">
        <ol class="flex space-x-2">
            <li><a href="#" class="text-yellow-600 hover:underline">Pengguna</a></li>
            <li>/</li>
            <li><a href="#" class="text-yellow-600 hover:underline">Data</a></li>
            <li>/</li>
            <li class="text-gray-500">Edit</li>
        </ol>
    </nav>

    <!-- Card -->
    <div class="bg-gray-50 rounded-xl p-6 shadow-sm">
        <h2 class="text-2xl font-semibold text-center mb-6 text-gray-800">Edit Data User</h2>

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap :</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 transition duration-200 @error('name') border-red-500 @enderror"
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email :</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 transition duration-200 @error('email') border-red-500 @enderror"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password :</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 transition duration-200 @error('password') border-red-500 @enderror"
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 transition">
                   Kembali
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
