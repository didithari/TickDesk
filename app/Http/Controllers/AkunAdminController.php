<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\DevRole;
use Illuminate\Support\Facades\Hash;

class AkunAdminController extends Controller
{
    public function index()
    {
        $admins = \DB::table('users')
            ->leftJoin('devRoles', 'users.devRoleID', '=', 'devRoles.id')
            ->where('users.privLevel', 'developer')
            ->select('users.*', 'devRoles.roleName')
            ->get();

        return view('Admin.akun', [
            'alldata' => $admins,
            'roles' => DevRole::all(),
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'nama' => 'required|max:150',
            'email' => 'nullable|email',
            'nohp' => 'nullable|max:20',
            'role' => 'required|exists:devRoles,id', // pastikan role wajib dan valid
            'pass' => 'required',
            'tgl' => 'nullable|date',
            'status' => 'nullable|in:active,Away',
            'upload' => 'nullable|mimes:jpg,png,jpeg,gif|max:5120',
        ]);

        $gambarUrl = null;
        if ($request->hasFile('upload')) {
            $gambar = $request->file('upload');
            $namaGambar = date('Ymd') . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('GambarProfileAdmin/'), $namaGambar);
            $gambarUrl = asset('GambarProfileAdmin/' . $namaGambar);
        }

        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->pass);
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->phone_number = $request->nohp;
        $user->privLevel = 'developer';
        $user->devRoleID = $request->role; // pastikan ini ID dari devRoles
        $user->status = $request->status ?? 'Away';
        $user->created_at = $request->tgl ?? now();
        $user->updated_at = now();
        $user->profile_picture = $gambarUrl;
        $user->save();

        return redirect()->route('akunadmin', ['alert' => 'success']);
    }

    public function hapusData($username)
    {
        $user = User::where('username', $username)->first();

        if ($user) {
            try {
                if ($user->profile_picture) {
                    $namaGambar = basename($user->profile_picture);
                    $gambarPath = public_path('GambarProfileAdmin/' . $namaGambar);
                    if (file_exists($gambarPath)) {
                        unlink($gambarPath);
                    }
                }

                $user->delete();

                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => 'Data tidak dapat dihapus karena berelasi dengan data lainnya!'
                ]);
            }
        }

        return response()->json(['error' => true, 'message' => 'Data tidak ditemukan!']);
    }

    public function edit($username)
    {
        $akun = User::where('username', $username)->first();
        $roles = DevRole::all();

        if (!$akun) {
            return redirect()->route('akunadmin')->with('error', 'Akun tidak ditemukan.');
        }

        return view('Admin.akun_edit', [
            'akun' => $akun,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, $username)
    {
        $akun = User::where('username', $username)->first();

        if (!$akun) {
            return redirect()->route('akunadmin')->with('error', 'Akun tidak ditemukan.');
        }

        $request->validate([
            'nama' => 'required|max:150',
            'email' => 'required|email',
            'nohp' => 'required|max:20',
            'role' => 'required',
            'upload' => 'nullable|mimes:jpg,jpeg,png,gif|max:5120'
        ]);

        if ($request->hasFile('upload')) {
            if ($akun->profile_picture) {
                $oldImage = public_path('GambarProfileAdmin/' . basename($akun->profile_picture));
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $file = $request->file('upload');
            $filename = date('Ymd') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('GambarProfileAdmin/'), $filename);
            $akun->profile_picture = asset('GambarProfileAdmin/' . $filename);
        }

        $akun->name = $request->nama;
        $akun->email = $request->email;
        $akun->phone_number = $request->nohp;
        $akun->devRoleID = $request->role;
        $akun->updated_at = now();
        $akun->save();

        return redirect()->route('akunadmin')->with('success', 'Data berhasil diperbarui.');
    }
}
