@extends('template.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Breadcrumb --}}
    <nav class="mb-8 text-sm font-medium text-gray-700">
        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-500">Riwayat Booking</span>
    </nav>

    {{-- Judul Halaman --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Riwayat Booking Saya</h1>

    {{-- Jika belum ada booking --}}
    @if($bookings->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-10 text-center shadow-sm">
            <i class="fas fa-calendar-times text-yellow-500 text-5xl mb-4"></i>
            <p class="text-gray-700 text-lg mb-3">Anda belum memiliki booking.</p>
            <a href="{{ route('user.jenis_kamar') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg transition">
                <i class="fas fa-bed"></i> Booking Kamar Sekarang
            </a>
        </div>
    @else
        {{-- Tabel Booking --}}
        <div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-gray-100">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Kode</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Kamar</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Check-in</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Check-out</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Total</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Status</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                        @php
                            $statusColors = [
                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                'Diterima' => 'bg-green-100 text-green-800',
                                'Ditolak' => 'bg-red-100 text-red-800',
                                'Dibatalkan' => 'bg-red-100 text-red-800'
                            ];
                            $colorClass = $statusColors[$booking->status_pemesanan] ?? 'bg-gray-100 text-gray-800';
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            {{-- Kode Booking --}}
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ $booking->p_lu_Pemesanan }}
                            </td>

                            {{-- Nama & Gambar Kamar --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $booking->image) }}"
                                         class="w-12 h-12 object-cover rounded-lg shadow-sm border border-gray-200">
                                    <span class="font-medium text-gray-800">{{ $booking->nama_kamar }}</span>
                                </div>
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-6 py-4">{{ date('d M Y', strtotime($booking->tgl_checkin)) }}</td>
                            <td class="px-6 py-4">{{ date('d M Y', strtotime($booking->tgl_checkout)) }}</td>

                            {{-- Total Harga --}}
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colorClass }}">
                                    {{ $booking->status_pemesanan }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    {{-- Jika Pending → Bayar & Batal --}}
                                    @if($booking->status_pemesanan == 'Pending')
                                        <a href="{{ route('user.booking.summary', $booking->id) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-xs font-medium transition">
                                           Bayar
                                        </a>
                                        <form action="{{ route('user.booking.cancel', $booking->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    onclick="return confirm('Batalkan booking ini?')"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-xs font-medium transition">
                                                Batal
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Jika sudah Diterima → tampilkan tombol QR --}}
                                    @if(strtolower($booking->status_pemesanan) == 'diterima')
                                        <a href="{{ route('user.booking.qr', $booking->id) }}"
                                           class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-xs font-medium transition">
                                           <i class="fas fa-qrcode mr-1"></i> Lihat QR
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-center">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
