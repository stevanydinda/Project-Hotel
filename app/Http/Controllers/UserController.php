<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function home()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.jenis_kamar');
        }

        return view('home');
    }

    public function authlogin()
    {
        return view('auth.login');
    }

    public function authsignup()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $createData = User::create([
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        if ($createData) {
            return redirect()->route('login')->with('success', 'Berhasil membuat akun. Silahkan login');
        }

        return redirect()->back()->with('error', 'Gagal silahkan coba lagi.');
    }

    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            // FOTO DIHAPUS DI SINI
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        // HAPUS SEMUA LOGIKA FOTO / UPLOAD
        // (bagian hasFile('foto') dan session upload)

        $data = $request->only(['email', 'password']);

        if (Auth::attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil login !');
            } else {
                return redirect()->route('home')->with('success', 'Berhasil login !');
            }
        }

        return redirect()->back()->with('error', 'Gagal ! pastikan email dan password sesuai');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('logout', 'Berhasil logout');
    }

    public function index()
    {
        $users = User::get();

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Berhasil menambahkan data!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:dns',
        ]);

        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Berhasil mengubah data!');
    }

    public function trash()
    {
        $users = User::onlyTrashed()->get();

        return view('admin.user.trash', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->restore();

        return redirect()->route('admin.users.index')->with('success', 'Berhasil membalikan data!');
    }

    public function deletePermanent($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->forceDelete();

        return redirect()->back()->with('success', 'Berhasil menghapus seutuhnya');
    }

    public function destroy(string $id)
    {
        User::where('id', $id)->delete();

        return redirect()->route('admin.users.index')->with('success', 'Berhasil menghapus data!');
    }

    public function exportExcel()
    {
        return Excel::download(new UserExport, 'data-User.xlsx');
    }
}
