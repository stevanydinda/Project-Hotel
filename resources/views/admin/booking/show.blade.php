@extends('template.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-10">

        <div class="bg-white shadow-lg rounded-xl w-full max-w-xl px-8 py-6">

            <h2 class="text-2xl font-bold text-center text-yellow-700 mb-6">
                Detail Booking
            </h2>

            <div class="space-y-4">

                <p><span class="font-semibold text-gray-700">Kode Booking:</span> {{ $booking->p_lu_Pemesanan }}</p>

                <p><span class="font-semibold text-gray-700">Nama Kamar:</span> {{ $booking->rooms->tipe_kamar }}</p>

                <p><span class="font-semibold text-gray-700">Check-in:</span> {{ $booking->tgl_checkin }}</p>

                <p><span class="font-semibold text-gray-700">Check-out:</span> {{ $booking->tgl_checkout }}</p>

                <p><span class="font-semibold text-gray-700">Jumlah Kamar:</span> {{ $booking->jnu_kamar_dipesan }}</p>

                @php
                    $status = strtolower(trim($booking->status_pemesanan));

                    $badgeClass = match ($status) {
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'diterima' => 'bg-green-100 text-green-800',
                        default => 'bg-red-100 text-red-800',
                    };
                @endphp

                <p>
                    <span class="font-semibold text-gray-700">Status:</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                        {{ ucfirst($status) }}
                    </span>
                </p>

            </div>

            <div class="flex justify-center gap-3 mt-8">
                <a href="{{ route('admin.bookings.index') }}"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded transition">
                    Kembali
                </a>

                <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded transition">
                    Update Booking
                </a>
            </div>

        </div>

    </div>
@endsection
