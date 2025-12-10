@extends('template.app')

@section('content')
<div class="container mx-auto px-4 py-6 text-center">
    <h1 class="text-2xl font-bold mb-4">QR Code Check-in</h1>
    <p class="text-gray-600 mb-6">
        Tunjukkan QR Code ini saat check-in di hotel.
    </p>


    @if(Storage::disk('public')->exists('qrcodes/' . $booking->p_lu_Pemesanan . '.svg'))
        <img src="{{ $qrPath }}" alt="QR Code" class="mx-auto w-60 h-60">
    @else

        {!! $qrSvg !!}
    @endif

    <div class="mt-6">
        <a href="{{ route('user.my.bookings') }}" class="text-blue-600 hover:text-blue-800">
            ← Kembali ke Riwayat Booking
        </a>
    </div>
</div>
@endsection
