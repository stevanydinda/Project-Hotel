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

    public function datatables()
    {
        $rooms = Room::query();

        return DataTables::of($rooms)
            ->addIndexColumn()
            ->addColumn('gambar', function($row) {
                if ($row->image) {
                    return '<img src="' . Storage::url($row->image) . '" alt="Gambar Kamar" class="w-16 h-16 object-cover">';
                }
                return 'No Image';
            })
            ->addColumn('kamar', fn($row) => $row->tipe_kamar)
            ->addColumn('jumlah', fn($row) => $row->jumlah_kamar)
            ->addColumn('kapasitas', fn($row) => $row->kapasitas)
            ->addColumn('harga', fn($row) => number_format($row->harga, 0, ',', '.'))
            ->rawColumns(['gambar', 'kamar'])
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
            'deskripsi' => 'required|string|max:255',
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $path = $request->image->storeAs('rooms', $filename, 'public');
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

    public function edit(Room $room)
    {
        return view('admin.room.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'tipe_kamar'    => 'required|string|max:255',
            'harga'         => 'required|numeric',
            'jumlah_kamar'  => 'required|integer|min:0',
            'hotel_id'      => 'nullable|integer',
            'kapasitas'     => 'required|integer|min:1',
            'deskripsi'     => 'nullable|string',
            'image'         => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($data);

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Kamar dipindahkan ke trash.');
    }

    public function trash()
    {
        $rooms = Room::onlyTrashed()->paginate(10);
        return view('admin.room.trash', compact('rooms'));
    }

    public function restore($id)
    {
        $room = Room::onlyTrashed()->findOrFail($id);
        $room->restore();
        return redirect()->route('rooms.trash')->with('success', 'Kamar dikembalikan.');
    }

    public function forceDelete($id)
    {
        $room = Room::onlyTrashed()->findOrFail($id);
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }
        $room->forceDelete();
        return redirect()->route('rooms.trash')->with('success', 'Kamar dihapus permanen.');
    }

    public function userIndex()
    {
        $rooms = Room::where('jumlah_kamar', '>', 0)->get();
        return view('user.jenis-kamar', compact('rooms'));
    }

    public function userShow(Room $room)
    {
        return view('user.room-detail', compact('room'));
    }
}
