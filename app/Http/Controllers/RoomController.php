<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{
    public function index()
    {

        return view('admin.room.index');

    }

    public function datatables(Request $request)
    {
        $rooms = Room::query();

       
        if ($request->search['value']) {
            $keyword = $request->search['value'];

            $rooms->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhere('tipe_kamar', 'like', "%$keyword%")
                    ->orWhere('deskripsi', 'like', "%$keyword%");
            });
        }

        return DataTables::of($rooms)
            ->addIndexColumn()

            ->addColumn('gambar', function ($row) {
                if ($row->image) {
                    return '<img src="'.asset('storage/'.$row->image).'" class="w-16 h-16 object-cover rounded">';
                }

                return '<span class="text-red-500">No Image</span>';
            })

            ->addColumn('kamar', fn ($row) => $row->tipe_kamar)
            ->addColumn('jumlah', fn ($row) => $row->jumlah_kamar)
            ->addColumn('kapasitas', fn ($row) => $row->kapasitas)
            ->addColumn('harga', fn ($row) => number_format($row->harga, 0, ',', '.'))

            ->addColumn('deskripsi', function ($row) {
                return '<div style="max-width:300px;white-space:normal;">'
                    .e($row->deskripsi).
                '</div>';
            })

            ->rawColumns(['gambar', 'deskripsi'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.room.create');
    }

    public function store(Request $request)
    {
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

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
        }

        Room::create([
            'name' => $request->name,
            'kapasitas' => $request->kapasitas,
            'image' => $path,
            'tipe_kamar' => $request->tipe_kamar,
            'harga' => $request->harga,
            'jumlah_kamar' => $request->jumlah_kamar,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Data kamar berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function userIndex()
    {
        $rooms = Room::all();

        return view('user.room.index', compact('rooms'));
    }

    public function userShow(Room $room)
    {
        return view('user.room.show', compact('room'));
    }

    public function orderStore(Request $request, Room $room)
    {

        $request->validate([
            'nama' => 'required|string',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'jumlah' => 'required|integer|min:1',
        ]);

        return back()->with('success', 'Pemesanan berhasil!');
    }
}
