<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Storage untuk akses file di storage/app/public
use Illuminate\Support\Str;             // Str::random dipakai buat kode booking random
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Library untuk generate QR Code

class BookingController extends Controller
{
    public function userCreate(Room $room)
    {
        // compact('room') = kirim variable $room ke view tanpa array manual
        return view('user.booking.create', compact('room'));
    }

    public function userStore(Request $request, Room $room)
    {
        // Validasi input user
        $request->validate([
            'tgl_checkin' => 'required|date',
            'tgl_checkout' => 'required|date|after:tgl_checkin',
            'jnu_kamar_dipesan' => 'required|integer|min:1',
        ]);

        // Cek stok kamar masih cukup atau tidak
        if ($request->jnu_kamar_dipesan > $room->jumlah_kamar) {
            return back()->with('error', 'Stok kamar tidak cukup.');
        }

        // Str::random → buat kode booking unik acak
        $kode = 'BOOK-'.strtoupper(Str::random(8));

        // Create data booking
        $booking = Booking::create([
            'p_lu_Pemesanan' => $kode,
            'id_User' => auth()->id(),      // Ambil ID user login
            'id_Kamar' => $room->id,
            'tgl_checkin' => $request->tgl_checkin,
            'tgl_checkout' => $request->tgl_checkout,
            'jnu_kamar_dipesan' => $request->jnu_kamar_dipesan,
            'status_pemesanan' => 'pending',
        ]);

        // Kurangi stok kamar setelah booking dibuat
        $room->jumlah_kamar -= $request->jnu_kamar_dipesan;
        $room->save();

        return redirect()->route('user.booking.summary', $booking->id);
    }

    public function userShowSummary($id)
    {
        // with('rooms') = eager loading untuk ambil relasi kamar sekaligus (lebih cepat)
        $booking = Booking::with('rooms')->findOrFail($id);
        // findOrFail = kalau data tidak ada → otomatis 404

        return view('user.booking.summary', compact('booking'));
    }

    public function cancelBooking($id)
    {
        $booking = Booking::with('rooms')->findOrFail($id);

        // Pastikan user yang membatalkan adalah pemilik booking
        if ($booking->id_User != auth()->id()) {
            return back()->with('error', 'Booking tidak bisa dibatalkan!');
        }

        // Hanya booking pending yang bisa dibatalkan
        if (strtolower($booking->status_pemesanan) != 'pending') {
            return back()->with('error', 'Booking sudah diproses dan tidak bisa dibatalkan!');
        }

        // Kembalikan stok kamar yang dibooking
        if ($booking->rooms) {
            $booking->rooms->jumlah_kamar += $booking->jnu_kamar_dipesan;
            $booking->rooms->save();
        }

        // Ubah status booking
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

        $bookings->getCollection()->transform(function ($booking) {
            if ($booking->rooms) {
                $booking->total_harga = $booking->rooms->harga * $booking->jnu_kamar_dipesan;
                $booking->tipe_kamar = $booking->rooms->nama;
                $booking->image = $booking->rooms->image;
            } else {
                $booking->total_harga = 0;
                $booking->tipe_kamar = 'Kamar sudah dihapus';
                $booking->image = 'default.jpg';
            }

            return $booking;
        });

        return view('user.booking.index', compact('bookings'));
    }

    public function index()
    {
        // with(['rooms']) untuk load relasi kamar agar tidak query berulang
        $bookings = Booking::with(['rooms'])->latest()->get();

        return view('admin.booking.index', compact('bookings'));
    }

    public function adminShow($id)
    {
        $booking = Booking::with(['rooms'])->findOrFail($id); // findOrFail = 404 kalau tidak ada

        return view('admin.booking.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $rooms = Room::all(); // Data kamar untuk dropdown
        $users = User::all(); // Data user untuk dropdown

        return view('admin.booking.edit', compact('booking', 'rooms', 'users'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'id_User' => 'required|integer',
            'id_Kamar' => 'required|integer',
            'tgl_checkin' => 'required|date',
            'tgl_checkout' => 'required|date|after:tgl_checkin',
            'jnu_kamar_dipesan' => 'required|integer|min:1',
            'status_pemesanan' => 'required|string',
        ]);

        $oldRoom = Room::findOrFail($booking->id_Kamar);
        $newRoom = Room::findOrFail($request->id_Kamar);

        $oldQty = $booking->jnu_kamar_dipesan;
        $newQty = $request->jnu_kamar_dipesan;

        if ($booking->id_Kamar != $request->id_Kamar) {

            // Kembalikan stok kamar lama
            $oldRoom->jumlah_kamar += $oldQty;
            $oldRoom->save();

            // Pastikan kamar baru stok cukup
            if ($newQty > $newRoom->jumlah_kamar) {
                return back()->with('error', 'Stok kamar baru tidak cukup!');
            }

            // Kurangi stok kamar baru
            $newRoom->jumlah_kamar -= $newQty;
            $newRoom->save();

        }

        // Update booking
        $booking->update([
            'id_User' => $request->id_User,
            'id_Kamar' => $request->id_Kamar,
            'tgl_checkin' => $request->tgl_checkin,
            'tgl_checkout' => $request->tgl_checkout,
            'jnu_kamar_dipesan' => $request->jnu_kamar_dipesan,
            'status_pemesanan' => $request->status_pemesanan,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil diperbarui.');
    }

    public function datatables()
    {
        // with(['rooms', 'user']) → load relasi kamar & user sekaligus
        $bookings = Booking::with(['rooms', 'user'])->latest()->get();

        return datatables()->of($bookings)
            ->addIndexColumn() // nomor urut
            ->addColumn('kode_booking', fn ($b) => $b->p_lu_Pemesanan)
            ->addColumn('nama_kamar', fn ($b) => $b->rooms ? $b->rooms->tipe_kamar : '-')
            ->addColumn('customer_name', fn ($b) => $b->user ? $b->user->name : '-')

            // Format total harga → number_format
            ->addColumn('total_harga', fn ($b) => $b->rooms ? 'Rp '.number_format($b->rooms->harga * $b->jnu_kamar_dipesan, 0, ',', '.') : 'Rp 0'
            )

            ->addColumn('checkin', fn ($b) => $b->tgl_checkin)
            ->addColumn('checkout', fn ($b) => $b->tgl_checkout)
            ->addColumn('jumlah_kamar', fn ($b) => $b->jnu_kamar_dipesan)
            ->addColumn('status', fn ($b) => $b->status_pemesanan)

            // raw HTML untuk tombol View & Edit
            ->addColumn('actions', function ($b) {
                $viewUrl = route('admin.bookings.show', $b->id);
                $editUrl = route('admin.bookings.edit', $b->id);
                $deleteUrl = route('admin.bookings.delete', $b->id);

                return '
        <div class="flex space-x-2 justify-center">

            <a href="'.$viewUrl.'"
                class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-2 py-1 rounded transition">
                View
            </a>

            <a href="'.$editUrl.'"
                class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold px-2 py-1 rounded transition">
                Edit
            </a>

            <form action="'.$deleteUrl.'" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus?\')">
                '.csrf_field().method_field('DELETE').'
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded transition">
                    Delete
                </button>
            </form>
        </div>
    ';
            })
            ->rawColumns(['actions']) // rawColumns = biar HTML ga di-escape
            ->make(true);
    }

    public function dataChart()
    {
        // Ambil booking diterima + ditolak
        $bookings = Booking::whereIn('status_pemesanan', ['Diterima', 'Ditolak'])
            ->get()
            ->groupBy(function ($booking) {
                return $booking->created_at->format('Y-m'); // Group per bulan
            })
            ->toArray();

        $labels = array_keys($bookings);
        $data = [];
        $data_rejected = [];

        // Hitung jumlah booking per bulan
        foreach ($bookings as $booking) {

            // Diterima
            $data[] = collect($booking)
                ->where('status_pemesanan', 'Diterima')
                ->count();

            // Ditolak
            $data_rejected[] = collect($booking)
                ->where('status_pemesanan', 'Ditolak')
                ->count();
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,            // diterima
            'data_rejected' => $data_rejected,   // ditolak
        ]);
    }

    public function showQr($id)
    {
        // Load booking + relasi rooms
        $booking = Booking::with('rooms')->findOrFail($id);

        // Hanya tampil jika status diterima
        if (strtolower($booking->status_pemesanan) !== 'diterima') {
            return back()->with('error', 'QR hanya tersedia jika booking sudah diterima oleh admin.');
        }

        // Cek folder qrcodes di storage/public
        if (! Storage::disk('public')->exists('qrcodes')) {
            Storage::disk('public')->makeDirectory('qrcodes'); // buat folder
        }

        // Nama file QR
        $fileName = $booking->p_lu_Pemesanan.'.svg';
        $filePath = 'qrcodes/'.$fileName;

        // Generate QR Code
        $qrSvg = QrCode::format('svg')
            ->size(300)
            ->margin(2)
            ->errorCorrection('H') // tingkat koreksi tinggi
            ->generate($booking->p_lu_Pemesanan);

        // Simpan file kalau belum ada
        if (! Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->put($filePath, $qrSvg);
        }

        // Path public untuk ditampilkan di view
        $qrPath = asset('storage/'.$filePath);

        return view('user.booking.qr', compact('booking', 'qrPath', 'qrSvg'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'id_User' => 'required|integer',
            'id_Kamar' => 'required|integer',
            'tgl_checkin' => 'required|date',
            'tgl_checkout' => 'required|date|after:tgl_checkin',
            'jnu_kamar_dipesan' => 'required|integer|min:1',
            'status_pemesanan' => 'required|string',
        ]);

        $room = Room::findOrFail($request->id_Kamar);

        // Cek stok
        if ($request->jnu_kamar_dipesan > $room->jumlah_kamar) {
            return back()->with('error', 'Stok kamar tidak cukup!');
        }

        // Buat kode booking
        $kode = 'BOOK-'.strtoupper(Str::random(8));

        // Create booking
        $booking = Booking::create([
            'p_lu_Pemesanan' => $kode,
            'id_User' => $request->id_User,
            'id_Kamar' => $request->id_Kamar,
            'tgl_checkin' => $request->tgl_checkin,
            'tgl_checkout' => $request->tgl_checkout,
            'jnu_kamar_dipesan' => $request->jnu_kamar_dipesan,
            'status_pemesanan' => $request->status_pemesanan,
        ]);

        // Kurangi stok kamar
        $room->jumlah_kamar -= $request->jnu_kamar_dipesan;
        $room->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibuat.');
    }

    public function trash()
    {
        $bookings = Booking::onlyTrashed()->with('rooms', 'user')->get();

        return view('admin.booking.trash', compact('bookings'));
    }

    // Soft delete
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        // Kembalikan stok kamar sebelum hapus
        $room = Room::find($booking->id_Kamar);
        if ($room) {
            $room->jumlah_kamar += $booking->jnu_kamar_dipesan;
            $room->save();
        }

        $booking->delete();

        return back()->with('success', 'Booking dipindahkan ke Trash.');
    }

    // Restore data dari trash
    public function restore($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);

        // Kurangi lagi stok kamar
        $room = Room::find($booking->id_Kamar);
        if ($room) {
            if ($room->jumlah_kamar < $booking->jnu_kamar_dipesan) {
                return back()->with('error', 'Stok kamar tidak cukup untuk restore!');
            }
            $room->jumlah_kamar -= $booking->jnu_kamar_dipesan;
            $room->save();
        }

        $booking->restore();

        return back()->with('success', 'Booking berhasil direstore.');
    }

    // Hapus permanen
    public function deletePermanent($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);

        // Hapus permanen
        $booking->forceDelete();

        return redirect()->route('admin.bookings.trash')
            ->with('success', 'Booking berhasil dihapus permanen.');
    }
}
