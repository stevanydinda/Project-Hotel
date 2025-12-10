@extends('template.app')

@section('content')
    <div class="container mx-auto mt-6 px-4">

        @if (Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="flex justify-end space-x-2 mb-4">
            <a href="{{ route('admin.users.trash') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                Data Sampah User
            </a>
            <a href="{{ route('admin.users.export') }}"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                Export (.xlsx)
            </a>
            <a href="{{ route('admin.users.create') }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded">
                Tambah Data
            </a>

            {{-- Tombol Kembali --}}
            <a href="{{ url()->previous() }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <h2 class="text-xl font-bold mb-4">Data Pengguna (Admin & User)</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 text-sm text-left text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Role</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $key + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $user->name }}</td>
                            <td class="px-4 py-2 border">{{ $user->email }}</td>

                            <td class="px-4 py-2 border">
                                @if ($user->role === 'admin')
                                    <span class="inline-block bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                                        {{ $user->role }}
                                    </span>
                                @else
                                    <span class="inline-block bg-green-500 text-white text-xs px-2 py-1 rounded">
                                        {{ $user->role }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-2 border">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
