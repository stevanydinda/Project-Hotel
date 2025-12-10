@extends('template.app')
@section('content')
    <div class="container mx-auto mt-6 px-4 max-w-2xl bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-6 text-center text-yellow-700">Edit Booking</h2>

        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Kirim ID user --}}
            <input type="hidden" name="id_User" value="{{ $booking->id_User }}">

            {{-- Kirim ID kamar --}}
            <input type="hidden" name="id_Kamar" value="{{ $booking->id_Kamar }}">

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Kode Booking</label>
                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2"
                    value="{{ $booking->p_lu_Pemesanan }}" disabled>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">User</label>
                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2"
                    value="{{ $booking->user->name }}" disabled>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Kamar</label>
                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2"
                    value="{{ $booking->rooms->tipe_kamar }}" disabled>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Tanggal Check-in</label>
                <input type="date" name="tgl_checkin" class="w-full border border-gray-300 rounded px-3 py-2"
                    value="{{ $booking->tgl_checkin }}">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Tanggal Check-out</label>
                <input type="date" name="tgl_checkout" class="w-full border border-gray-300 rounded px-3 py-2"
                    value="{{ $booking->tgl_checkout }}">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Jumlah Kamar</label>
                <input type="number" name="jnu_kamar_dipesan" id="jnu_kamar_dipesan"
                    class="w-full border border-gray-300 rounded px-3 py-2" min="1"
                    value="{{ $booking->jnu_kamar_dipesan }}">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Status Pemesanan</label>
                <select class="w-full border border-gray-300 rounded px-3 py-2" name="status_pemesanan">
                    <option value="Pending" {{ $booking->status_pemesanan == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Diterima" {{ $booking->status_pemesanan == 'Diterima' ? 'selected' : '' }}>Diterima
                    </option>
                    <option value="Ditolak" {{ $booking->status_pemesanan == 'Ditolak' ? 'selected' : '' }}>Ditolak
                    </option>
                </select>
            </div>

            <div class="flex space-x-4 mt-4">
                <button type="submit"
                    class="bg-yellow-700 hover:bg-yellow-800 text-white font-semibold px-4 py-2 rounded transition">Simpan
                    Perubahan</button>
                <a href="{{ route('admin.bookings.index') }}"
                    class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-4 py-2 rounded transition">Batal</a>
            </div>
        </form>
    </div>
@endsection
