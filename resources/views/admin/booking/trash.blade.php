@extends('template.app')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-8">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-yellow-700">Data Sampah Booking</h2>

            <a href="{{ route('admin.bookings.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>

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
                        <th class="px-6 py-3 border-b">Kode Booking</th>
                        <th class="px-6 py-3 border-b">User</th>
                        <th class="px-6 py-3 border-b">Kamar</th>
                        <th class="px-6 py-3 border-b">Jumlah</th>
                        <th class="px-6 py-3 border-b">Tanggal Dihapus</th>
                        <th class="px-6 py-3 border-b text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bookings as $key => $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 border-b">{{ $key + 1 }}</td>

                            <td class="px-6 py-4 border-b">{{ $booking->kode_booking }}</td>

                            <td class="px-6 py-4 border-b">{{ $booking->user->name ?? '-' }}</td>

                            <td class="px-6 py-4 border-b">{{ $booking->room->tipe_kamar ?? '-' }}</td>

                            <td class="px-6 py-4 border-b">{{ $booking->jnu_kamar_dipesan }}</td>

                            <td class="px-6 py-4 border-b">
                                {{ $booking->deleted_at->format('d-m-Y H:i') }}
                            </td>

                            <td class="px-6 py-4 border-b text-center space-x-2">

                                {{-- Restore --}}
                                <form action="{{ route('admin.bookings.restore', $booking->id) }}"
                                      method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition">
                                        Kembalikan
                                    </button>
                                </form>

                                {{-- Delete Permanent --}}
                                <form action="{{ route('admin.bookings.deletePermanent', $booking->id) }}"
                                      method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus permanen booking ini?')"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                        Hapus Permanen
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                                Tidak ada data booking di sampah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
@endsection
