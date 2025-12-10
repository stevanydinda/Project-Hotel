@extends('template.app')

@section('content')
    <div class="container">
        <h2>Detail Booking</h2>

        <div class="card">
            <div class="card-body">

                <p><strong>Kode Booking:</strong> {{ $booking->kode_pemesanan }}</p>
                <p><strong>Nama Kamar:</strong> {{ $booking->room->nama_kamar }}</p>
                <p><strong>Check-in:</strong> {{ $booking->tgl_checkin }}</p>
                <p><strong>Check-out:</strong> {{ $booking->tgl_checkout }}</p>
                <p><strong>Jumlah Kamar:</strong> {{ $booking->jumlah_kamar_dipesan }}</p>

                <p><strong>Status:</strong>
                    <span
                        class="badge
                    @if ($booking->status_pemesanan == 'Pending') bg-warning
                    @elseif($booking->status_pemesanan == 'Diterima') bg-success
                    @else bg-danger @endif">
                        {{ $booking->status_pemesanan }}
                    </span>
                </p>

                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mt-3">Kembali</a>


                <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-primary mt-3">Update Booking</a>

            </div>
        </div>
    </div>
@endsection
