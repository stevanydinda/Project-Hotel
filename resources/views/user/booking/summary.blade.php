{{-- resources/views/user/booking/summary.blade.php --}}
@extends('template.app')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white">
                <h1 class="text-2xl font-bold text-center">RINGKASAN BOOKING</h1>
                <p class="text-center text-blue-100">Kode: {{ $booking->p_lu_Pemesanan }}</p>
            </div>

            <div class="p-6">
                <!-- Room Info -->
                <div class="flex flex-col md:flex-row gap-6 mb-8">
                    @if ($booking->rooms->image)
                        <img src="{{ asset('storage/' . $booking->rooms->image) }}"
                            class="w-full md:w-48 h-48 object-cover rounded-xl">
                    @else
                        <div class="w-full md:w-48 h-48 bg-gray-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif

                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $booking->rooms->name }}</h2>
                        <p class="text-gray-600 mb-4">{{ $booking->rooms->description ?? 'Kamar nyaman untuk menginap' }}
                        </p>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center">
                                <i class="fas fa-users text-blue-500 mr-3"></i>
                                <span>Kapasitas: {{ $booking->rooms->kapasitas }} orang</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-bed text-blue-500 mr-3"></i>
                                <span>Stok: {{ $booking->rooms->jumlah_kamar }} kamar</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Details + Price -->
                @php
                    $nights = \Carbon\Carbon::parse($booking->tgl_checkin)->diffInDays($booking->tgl_checkout);
                    $totalPrice = $booking->rooms->harga * $nights * $booking->jnu_kamar_dipesan;
                @endphp

                <div class="bg-gray-50 rounded-xl p-5 mb-6">
                    <h3 class="font-bold text-gray-800 mb-4">Detail Booking</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="mb-3">
                                <label class="block text-gray-600 text-sm mb-1">Check-in</label>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-check text-green-500 mr-3"></i>
                                    <span class="font-bold">{{ date('d M Y', strtotime($booking->tgl_checkin)) }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">Check-out</label>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-times text-red-500 mr-3"></i>
                                    <span class="font-bold">{{ date('d M Y', strtotime($booking->tgl_checkout)) }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-3">
                                <label class="block text-gray-600 text-sm mb-1">Jumlah Malam</label>
                                <div class="flex items-center">
                                    <i class="fas fa-moon text-purple-500 mr-3"></i>
                                    <span class="font-bold">{{ $nights }} Malam</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="block text-gray-600 text-sm mb-1">Jumlah Kamar</label>
                                <div class="flex items-center">
                                    <i class="fas fa-door-closed text-orange-500 mr-3"></i>
                                    <span class="font-bold">{{ $booking->jnu_kamar_dipesan }} Kamar</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-600 text-sm mb-1">Total Harga</label>
                                <div class="flex items-center">
                                    <i class="fas fa-wallet text-green-500 mr-3"></i>
                                    <span class="font-bold text-green-600">
                                        Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                @php $status = strtolower($booking->status_pemesanan); @endphp
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-gray-600">Status:</span>
                            <span
                                class="ml-2 px-3 py-1 rounded-full text-sm font-bold
                            @if ($status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($status == 'diterima') bg-green-100 text-green-800
                            @elseif($status == 'ditolak') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                                {{ strtoupper($booking->status_pemesanan) }}
                            </span>
                        </div>
                        <div class="text-gray-500 text-sm">
                            <i class="far fa-clock mr-1"></i>
                            {{ $booking->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Bottom Buttons: Cancel & Pay -->
                <div class="flex justify-between items-center mt-6">
                    <form action="{{ route('user.booking.cancel', $booking->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin membatalkan booking?')">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            Batalkan Booking
                        </button>
                    </form>
                </div>
                @endsection
