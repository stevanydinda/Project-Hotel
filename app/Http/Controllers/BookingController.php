<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingController extends Controller
{

    public function userCreate(Room $room)
    {
        return view('user.booking.create', compact('room'));
    }

    public function userStore(Request $request, Room $room)
    {
        $request->validate([
            'tgl_checkin' => 'required|date',
            'tgl_checkout' => 'required|date|after:tgl_checkin',
            'jnu_kamar_dipesan' => 'required|integer|min:1',
        ]);

        if ($request->jnu_kamar_dipesan > $room->jumlah_kamar) {
            return back()->with('error', 'Stok kamar tidak cukup.');
        }

        $kode = 'BOOK-'.strtoupper(Str::random(8));

        $booking = Booking::create([
            'p_lu_Pemesanan' => $kode,
            'id_User' => auth()->id(),
            'id_Kamar' => $room->id,
            'tgl_checkin' => $request->tgl_checkin,
            'tgl_checkout' => $request->tgl_checkout,
            'jnu_kamar_dipesan' => $request->jnu_kamar_dipesan,
            'status_pemesanan' => 'pending',
        ]);

        // Kurangi stok kamar
        $room->jumlah_kamar -= $request->jnu_kamar_dipesan;
        $room->save();

        return redirect()->route('user.booking.summary', $booking->id);
    }

    public function userShowSummary($id)
    {
        $booking = Booking::with('rooms')->findOrFail($id);

        return view('user.booking.summary', compact('booking'));
    }


    public function cancelBooking($id)
    {
        $booking = Booking::with('rooms')->findOrFail($id);

        // Pastikan user yang cancel adalah owner booking
        if ($booking->id_User != auth()->id()) {
            return back()->with('error', 'Booking tidak bisa dibatalkan!');
        }

        // Hanya pending yang bisa dibatalkan
        if (strtolower($booking->status_pemesanan) != 'pending') {
            return back()->with('error', 'Booking sudah diproses dan tidak bisa dibatalkan!');
        }

        // Kembalikan stok kamar
        if ($booking->rooms) {
            $booking->rooms->jumlah_kamar += $booking->jnu_kamar_dipesan;
            $booking->rooms->save();
        }

        // Update status booking
        $booking->status_pemesanan = 'Dibatalkan';
        $booking->save();

        return redirect()->route('user.jenis_kamar')->with('success', 'Booking berhasil dibatalkan.');
    }


    public function myBookings()
    {
        $userId = auth()->id();
        $bookings = Booking::where('id_User', $userId)
            ->with('rooms')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $bookings->transform(function ($booking) {
            $booking->total_harga = $booking->rooms->harga * $booking->jnu_kamar_dipesan;

            return $booking;
        });

        return view('user.booking.index', compact('bookings'));
    }

    public function index()
    {
        $bookings = Booking::with(['rooms'])->latest()->get();

        return view('admin.booking.index', compact('bookings'));
    }

    public function adminShow($id)
    {
        $booking = Booking::with(['rooms'])->findOrFail($id);

        return view('admin.booking.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $rooms = Room::all();
        $users = User::all();

        return view('admin.booking.edit', compact('booking', 'rooms', 'users'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'tgl_checkin' => 'required|date',
            'tgl_checkout' => 'required|date',
            'jnu_kamar_dipesan' => 'required|integer|min:1',
            'status_pemesanan' => 'required|string',
        ]);

        $booking->update([
            'id_User' => $request->id_User ?? $booking->id_User,
            'id_Kamar' => $request->id_Kamar ?? $booking->id_Kamar,
            'tgl_checkin' => $request->tgl_checkin,
            'tgl_checkout' => $request->tgl_checkout,
            'jnu_kamar_dipesan' => $request->jnu_kamar_dipesan,
            'status_pemesanan' => $request->status_pemesanan,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Data booking berhasil diperbarui');
    }

    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();

        return back()->with('success', 'Booking berhasil dihapus');
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status_pemesanan = $request->status;
        $booking->save();

        return back()->with('success', 'Status berhasil diperbarui');
    }



    public function datatables()
    {
        $bookings = Booking::with(['rooms', 'user'])->latest()->get();

        return datatables()->of($bookings)
            ->addIndexColumn()
            ->addColumn('kode_booking', fn ($b) => $b->p_lu_Pemesanan)
            ->addColumn('nama_kamar', fn ($b) => $b->rooms ? $b->rooms->tipe_kamar : '-')
            ->addColumn('customer_name', fn ($b) => $b->user ? $b->user->name : '-')
            ->addColumn('total_harga', fn ($b) => $b->rooms ? 'Rp '.number_format($b->rooms->harga * $b->jnu_kamar_dipesan, 0, ',', '.') : 'Rp 0')
            ->addColumn('checkin', fn ($b) => $b->tgl_checkin)
            ->addColumn('checkout', fn ($b) => $b->tgl_checkout)
            ->addColumn('jumlah_kamar', fn ($b) => $b->jnu_kamar_dipesan)
            ->addColumn('status', fn ($b) => $b->status_pemesanan)
            ->addColumn('actions', function ($b) {
                $viewUrl = route('admin.bookings.show', $b->id);
                $editUrl = route('admin.bookings.edit', $b->id);

                return '
                    <div class="flex space-x-2 justify-center">
                        <a href="'.$viewUrl.'" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-2 py-1 rounded transition">View</a>
                        <a href="'.$editUrl.'" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold px-2 py-1 rounded transition">Edit</a>
                    </div>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function dataChart()
    {
        $bookings = Booking::where('status_pemesanan', 'Diterima')->get()->groupby(function ($booking) {
            return $booking->created_at->format('Y-m');
        })->toArray();
        $labels = array_keys($bookings);
        $data = [];
        foreach ($bookings as $booking) {
            array_push($data, count($booking));
        }

        return response()->json([

            'labels' => $labels,
            'data' => $data,
        ]);

    }

    public function showQr($id)
    {
        $booking = Booking::with('rooms')->findOrFail($id);

        // Hanya tampilkan QR kalau status sudah "Diterima"
        if (strtolower($booking->status_pemesanan) !== 'diterima') {
            return back()->with('error', 'QR hanya tersedia jika booking sudah diterima oleh admin.');
        }

        // Pastikan folder qrcodes ada
        if (! Storage::disk('public')->exists('qrcodes')) {
            Storage::disk('public')->makeDirectory('qrcodes');
        }

        // Nama file QR berdasarkan kode booking
        $fileName = $booking->p_lu_Pemesanan.'.svg';
        $filePath = 'qrcodes/'.$fileName;

        // Generate QR code SVG
        $qrSvg = QrCode::format('svg')
            ->size(300)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($booking->p_lu_Pemesanan);

        // Simpan ke storage/public/qrcodes
        if (! Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->put($filePath, $qrSvg);
        }

        // Path publik ke QR file
        $qrPath = asset('storage/'.$filePath);

        // Kirim ke view
        return view('user.booking.qr', compact('booking', 'qrPath', 'qrSvg'));
    }
}
