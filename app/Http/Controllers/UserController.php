<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function register(Request $request)
    {
        // Request $request : mengambil value request/input
        //dd(): debugging , cek data sebelum di proses
        //dd($request->all());

        //validasi
        $request->validate([
            // format  'name_input => validasi
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            //email:dns memastikan email valid
            'email' => 'required|email:dns',
            'password' => 'required'

        ], [
            //custom pesan
            //format : 'name_input.validasi' => 'pesan error
            'first_name.required' => 'Nama depan wajib diisi',
            'first_name.min' => 'Nama depan diisi minimal 3 karakter',
            'last_name.required' => 'Nama belakang wajib diisi',
            'last_name.min' => 'Nama belakang diisi minimal 3 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email diisi dengan data valid',
            'password.required' => 'Password wajib diisi'

        ]);

        //eloquent (fungsi: model) tambah data baru : create ([])
        $createData = User::create([
            //'column' => $request->name_input
            'name' => $request->first_name . " " . $request->last_name,
            'email' => $request->email,
            //enkripsi data : merubah menjadi karakter acak tidak ada yang bisa tau isi datanya : hash::make ()
            'password' => Hash::make($request->password),
            //role diisi langsung sebagai user agar tidak bisa menjadi admin/staff bagi pendaftar akun
            'role' => 'user'

        ]);
        if ($createData) {
            // redirect() perpindahan halaman, route() name route yang akan dipanggil
            // with () mengirim data session, biasanya untuk notif
            return redirect()->route('login')->with('success', 'Berhasil membuat akun. Silahkan login');

        } else {
            //back() kembali ke halaman sebelumnya yang dia akses
            return redirect()->back()->with('error', 'Gagal silahkan coba lagi.');
        }
    }
  public function loginAuth(Request $request)
{
    $request->validate([
        'email' => 'required',
        'password' => 'required',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // ← tambah validasi file
    ], [
        'email.required' => 'Email harus diisi',
        'password.required' => 'Password harus diisi'
    ]);

    // Jika user upload file, simpan ke storage
    if ($request->hasFile('foto')) {
        // Simpan ke storage/app/public/uploads
        $filePath = $request->file('foto')->store('uploads', 'public');

        // Jika ingin disimpan di database → tinggal buka komentar
        // Auth::user()->update(['foto' => $filePath]);

        // Atau bisa simpan ke session kalau hanya ingin ditampilkan
        session(['uploaded_foto' => $filePath]);
    }

    // menyimpan data yang akan diverifikasi
    $data = $request->only(['email', 'password']);

    // Auth::attempt()-> verfikasi kecocokan email-pw atau username-pw
    if (Auth::attempt($data)) {
        //setelah berhasil login, dicek lagi terkait role nya
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Berhasil login !');
        } else {
            return redirect()->route('home')->with('success', 'Berhasil login !');
        }
    } else {
        return redirect()->back()->with('error', 'Gagal ! pastikan email dan password sesuai');
    }
}

   public function logout(Request $request)
{
    \Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Arahkan ke home dengan pesan berhasil logout
    return redirect()->route('home')->with('logout', 'Berhasil logout');
}

    public function index()
    {
        $users = User::get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|min:3',
        'email' => 'required|email:dns',
        'password' => 'required',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    // Upload foto
    $filePath = null;
    if ($request->hasFile('foto')) {
        $filePath = $request->file('foto')->store('user_foto', 'public');
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user',
        'foto' => $filePath
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Berhasil menambahkan data!');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit($id)
   {
    $user = User::findOrFail($id);
    return view('admin.user.edit', compact('user'));
   }


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    $request->validate([
        'name' => 'required|min:3',
        'email' => 'required|email:dns',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $user = User::findOrFail($id);

    $data = [
        'name' => $request->name,
        'email' => $request->email
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // update foto
    if ($request->hasFile('foto')) {

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $filePath = $request->file('foto')->store('user_foto', 'public');
        $data['foto'] = $filePath;
    }

    $user->update($data);

    return redirect()->route('admin.users.index')->with('success', 'Berhasil mengubah data!');
}


     public function trash()
    {
    // Menampilkan user yang sudah dihapus (soft delete)
    $users =User::onlyTrashed()->get();

    return view('admin.user.trash', compact('users'));
    }

     public function restore($id)
    {
        $user= User::onlyTrashed()->find($id);
        $user->restore();
        return redirect()->route('admin.users.index')->with('success', 'Berhasil membalikan data!');
    }

    public function deletePermanent($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->forceDelete();
        return redirect()->back()->with('success', 'Berhasil menghapus seutuhnya');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         User::where('id', $id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Berhasil menghapus data!');
    }

    public function exportExcel()
    {
        // nama file yang akan terunduh
        $fileName = 'data-User.xlsx';
        // proses download
        return Excel::download(new UserExport, $fileName);
    }

    // ...existing code...

    public function profile(User $user)
    {
        return view('admin.user.profile', compact('user'));
    }

    public function editProfile(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function updateProfile(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // hapus file lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('admin.users.profile', $user)->with('success', 'Profil diperbarui.');
    }

    // ...existing code...
}


