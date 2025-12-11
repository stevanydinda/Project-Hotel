@extends('template.app')
@section('content')
    <div class="container mx-auto mt-6 px-4">

        @if (Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="flex justify-end space-x-2 mb-4">
            <div class="flex space-x-2">
                <a href="{{ url()->previous() }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
        <h5 class="mb-3 text-xl font-semibold text-center">Riwayat Booking</h5>
        <table id="tableBooking" class="min-w-[70%] mx-auto border border-gray-300 rounded-lg shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">#</th <th class="p-3">KodeBooking</th>
                    <th class="p-3">Kamar</th>
                    <th class="p-3">Check-in</th>
                    <th class="p-3">Check-out</th>
                    <th class="p-3">Jumlah Kamar</th>
                    <th class="p-3">Total Harga</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($bookings as $booking)
                    <tr>
                        <td class="p-3 text-center">{{ $loop->iteration }}</td>
                        <td class="p-3 text-center">{{ $booking->p_lu_Pemesanan }}</td>
                        <td class="p-3 text-center">{{ $booking->tipe_kamar }}</td>
                        <td class="p-3 text-center">{{ $booking->tgl_checkin }}</td>
                        <td class="p-3 text-center">{{ $booking->tgl_checkout }}</td>
                        <td class="p-3 text-center">{{ $booking->jnu_kamar_dipesan }}</td>
                        <td class="p-3 text-center">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                        <td class="p-3 text-center">{{ $booking->status_pemesanan }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    </div>
    </div>
@endsection
