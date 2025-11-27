@extends('template.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-yellow-700">Data Sampah User</h2>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            Kembali
        </a>
    </div>

    {{-- Alert sukses --}}
    @if (Session::get('success'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-gray-200">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-yellow-100 text-yellow-800 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-3 border-b">#</th>
                    <th class="px-6 py-3 border-b">Nama</th>
                    <th class="px-6 py-3 border-b">Email</th>
                    <th class="px-6 py-3 border-b">Role</th>
                    <th class="px-6 py-3 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $key => $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 border-b">{{ $key + 1 }}</td>
                        <td class="px-6 py-4 border-b font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4 border-b">{{ $user->email }}</td>
                        <td class="px-6 py-4 border-b">
                            @if ($user->role === 'admin')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Admin</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 border-b text-center space-x-2">
                            {{-- Tombol Restore --}}
                            <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition">
                                    Kembalikan
                                </button>
                            </form>

                            {{-- Tombol Hapus Permanen --}}
                            <form action="{{ route('admin.users.delete_permanent', $user->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus user ini secara permanen?')"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                    Hapus Permanen
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                            Tidak ada user di sampah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
