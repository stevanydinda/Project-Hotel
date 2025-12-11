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
                return '<div style="max-width:300px;white-space:normal;">'.e($row->deskripsi).'</div>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="'.route('admin.rooms.edit', $row->id).'" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>';

                $btn .= '
                    <form action="'.route('admin.rooms.destroy', $row->id).'" method="POST" style="display:inline;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';

                return $btn;
            })
            ->rawColumns(['gambar', 'deskripsi', 'action'])
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
            'harga' => 'required', // jangan numeric
            'jumlah_kamar' => 'required|integer',
            'deskripsi' => 'required|string',
        ]);

        // Bersihkan titik (contoh: 2.500.000 → 2500000)
        $harga = str_replace('.', '', $request->harga);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
        }

        Room::create([
            'name' => $request->name,
            'kapasitas' => $request->kapasitas,
            'image' => $path,
            'tipe_kamar' => $request->tipe_kamar,
            'harga' => $harga,
            'jumlah_kamar' => $request->jumlah_kamar,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Data kamar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);

        return view('admin.room.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tipe_kamar' => 'required|string',
            'harga' => 'required',
            'jumlah_kamar' => 'required|integer',
            'deskripsi' => 'required|string',
        ]);

        $room = Room::findOrFail($id);

        // Bersihkan titik (contoh: 2.500.000 → 2500000)
        $harga = str_replace('.', '', $request->harga);

        if ($request->hasFile('image')) {
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $room->image = $request->file('image')->store('rooms', 'public');
        }

        $room->update([
            'name' => $request->name,
            'kapasitas' => $request->kapasitas,
            'tipe_kamar' => $request->tipe_kamar,
            'harga' => $harga,
            'jumlah_kamar' => $request->jumlah_kamar,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Data kamar berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $room = Room::findOrFail($id);

       
        $bookingDiterima = $room->bookings()
            ->where('status_pemesanan', 'Diterima')
            ->exists();

        if ($bookingDiterima) {
            return back()->with('error', 'Kamar tidak bisa dihapus karena sedang dibooking atau sudah diterima.');
        }

        $room->delete();

        return back()->with('success', 'Kamar berhasil dihapus.');
    }

    public function trash()
    {
        $rooms = Room::onlyTrashed()->get();

        return view('admin.room.trash', compact('rooms'));
    }

    public function restore($id)
    {
        $room = Room::onlyTrashed()->findOrFail($id);
        $room->restore();

        return redirect()->route('admin.rooms.trash')->with('success', 'Data kamar berhasil dikembalikan.');
    }

    public function deletePermanent($id)
    {
        $room = Room::onlyTrashed()->findOrFail($id);

        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $room->forceDelete();

        return redirect()->route('admin.rooms.trash')->with('success', 'Data kamar berhasil dihapus permanen.');
    }

    // ------------------- User -------------------
    public function userindex()
    {
        $rooms = Room::all();

        return view('user.room.index', compact('rooms'));
    }

    public function userShow(Room $room)
    {
        return view('user.room.show', compact('room'));
    }
}
