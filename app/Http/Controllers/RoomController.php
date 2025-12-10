<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // buat hapus/simpan file ke storage
use Yajra\DataTables\Facades\DataTables; // biar datatables bisa jalan dari server

class RoomController extends Controller
{
    public function index()
    {
        // cuma nampilin halaman tabel aja, datanya nanti di-load via AJAX
        return view('admin.room.index');
    }

    public function datatables(Request $request)
    {
        // bikin query awal data kamar
        $rooms = Room::query();

        // fitur search datatables
        if ($request->search['value']) {
            $keyword = $request->search['value'];

            // pencarian semua kolom
            $rooms->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhere('tipe_kamar', 'like', "%$keyword%")
                    ->orWhere('deskripsi', 'like', "%$keyword%");
            });
        }

        // convert query ke format datatables
        return DataTables::of($rooms)
            ->addIndexColumn() // biar ada kolom nomor urut

            // kolom foto kamar
            ->addColumn('gambar', function ($row) {
                // asset() → ambil file yang ada di public/storage
                if ($row->image) {
                    return '<img src="'.asset('storage/'.$row->image).'" class="w-16 h-16 object-cover rounded">';
                }

                return '<span class="text-red-500">No Image</span>';
            })

            // kolom-kolom lain tinggal tampilin value masing2
            ->addColumn('kamar', fn ($row) => $row->tipe_kamar)
            ->addColumn('jumlah', fn ($row) => $row->jumlah_kamar)
            ->addColumn('kapasitas', fn ($row) => $row->kapasitas)

            // format harga biar ada titiknya
            ->addColumn('harga', fn ($row) => number_format($row->harga, 0, ',', '.'))

            // deskripsi dibatesin lebar biar ga meledak di tabel
            ->addColumn('deskripsi', function ($row) {
                return '<div style="max-width:300px;white-space:normal;">'
                    .e($row->deskripsi).
                '</div>';
            })

            // kasih tau datatables kalau ini HTML, jangan di-escape
            ->rawColumns(['gambar', 'deskripsi'])
            ->make(true);
    }

    public function create()
    {
        // tampilkan halaman form tambah kamar
        return view('admin.room.create');
    }

    public function store(Request $request)
    {
        // validasi data input dari admin
        $request->validate([
            'name' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tipe_kamar' => 'required|string',
            'harga' => 'required|integer',
            'jumlah_kamar' => 'required|integer',
            'deskripsi' => 'required|string|',
        ]);

        $path = null;

        // cek apakah admin upload gambar
        if ($request->hasFile('image')) {
            // simpan gambar ke storage/public/rooms
            $path = $request->file('image')->store('rooms', 'public');
        }

        // simpan data kamar ke database
        Room::create([
            'name' => $request->name,
            'kapasitas' => $request->kapasitas,
            'image' => $path,
            'tipe_kamar' => $request->tipe_kamar,
            'harga' => $request->harga,
            'jumlah_kamar' => $request->jumlah_kamar,
            'deskripsi' => $request->deskripsi,
        ]);

        // balik ke tabel kamar sambil bawa notif sukses
        return redirect()->route('admin.rooms.index')->with('success', 'Data kamar berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        // findOrFail → kalau ID ga ketemu langsung error 404
        $room = Room::findOrFail($id);

        // kalau ada file gambar, hapus dari storage
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        // hapus data dari database
        $room->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function userIndex()
    {
        // ambil semua kamar dan kirim ke view user
        $rooms = Room::all();

        return view('user.room.index', compact('rooms')); // compact = ngirim variabel ke view
    }

    public function userShow(Room $room)
    {
        // Room $room → otomatis dapet data kamar dari ID (route model binding)
        return view('user.room.show', compact('room'));
    }

    public function orderStore(Request $request, Room $room)
    {
        // validasi data yang diisi user saat mau pesan
        $request->validate([
            'nama' => 'required|string',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'jumlah' => 'required|integer|min:1',
        ]);

        // belum ada proses simpan, cuma notif aja
        return back()->with('success', 'Pemesanan berhasil!');
    }
}
