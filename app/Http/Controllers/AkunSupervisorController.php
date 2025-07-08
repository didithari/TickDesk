<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Akun;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AkunSupervisorController extends Controller
{
    protected $Akun;
    protected $Role;

    public function __construct()
    {
        $this->Akun = new Akun();
        $this->Role = new Role();
    }

    public function index()
{
    $alldata = [
        // hanya ambil data akun dengan lvlAkun = 1 (admin)
        'alldata' => $this->Akun->where('lvlAkun', 3)->get(),
        'roles' => $this->Role->all(),
    ];
    return view('spvacc.spv', $alldata);
}


    public function save(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'nama' => 'max:150',
            'role' => '',
            'pass' => '',
            'status' => '',
            'tgl' => '',
            'upload' => 'nullable|mimes:jpg,png,jpeg,gif|max:5120',
        ]);

        $gambarUrl = null;

        if ($request->hasFile('upload')) {
            $gambar = $request->file('upload');
            $namaGambar = date('Ymd') . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('GambarProfileAdmin/'), $namaGambar);
            $gambarUrl = asset('GambarProfileAdmin/' . $namaGambar);
        }

        $data = [
            'username' => $request->username,
            'password' => $request->pass,
            'name' => $request->nama,
            'status' => 'Away',
            'lvlAkun' => '3',
            'idRole' => $request->role,
            'created_at' => $request->tgl,
            'imgProfile' => $gambarUrl,
        ];


        $this->Akun->addData($data);

        return redirect()->route('akun.supervisor', ['alert' => 'success']);
    }

    public function hapusData($username)
    {
        $akun = Akun::where('username', $username)->first();

        if ($akun) {
            try {
                if ($akun->imgProfile) {
                    $namaGambar = basename($akun->imgProfile);
                    $gambarPath = public_path('GambarProfileAdmin/' . $namaGambar);
                    if (file_exists($gambarPath)) {
                        unlink($gambarPath);
                    }
                }

                $akun->delete();

                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => 'Data tidak dapat dihapus karena berelasi dengan data lainnya!'
                ]);
            }
        }

        return response()->json([
            'error' => true,
            'message' => 'Data tidak ditemukan!'
        ]);
    }

    public function edit($username)
    {
        $akun = Akun::where('username', $username)->first();
        $roles = Role::all();

        if (!$akun) {
            return redirect()->route('akunadmin')->with('error', 'Akun tidak ditemukan.');
        }

        return view('Support.edit', [
            'akun' => $akun,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, $username)
    {
        $akun = Akun::where('username', $username)->first();

        if (!$akun) {
            return redirect()->route('akunadmin')->with('error', 'Akun tidak ditemukan.');
        }

        $request->validate([
            'nama' => 'required|max:150',
            // 'role' => 'required',
            'upload' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120'
        ]);

        // Proses update gambar jika ada
        if ($request->hasFile('upload')) {
            if ($akun->imgProfile) {
                $oldImage = public_path('GambarProfileAdmin/' . basename($akun->imgProfile));
                if (File::exists($oldImage)) {
                    File::delete($oldImage);
                }
            }

            $file = $request->file('upload');
            $filename = date('Ymd') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('GambarProfileAdmin/'), $filename);
            $akun->imgProfile = asset('GambarProfileAdmin/' . $filename);
        }

        $akun->name = $request->nama;
        // $akun->idRole = $request->role;
        $akun->save();

        return redirect()->route('akun.supervisor')->with('success', 'Data berhasil diperbarui.');
    }
}
