<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Akun;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AkunSupportController extends Controller
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
        'alldata' => $this->Akun->where('lvlAkun', 2)->get(),
        'roles' => $this->Role->all(),
    ];
    return view('Support.support', $alldata);
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
            'lvlAkun' => '2',
            'idRole' => '4',
            'created_at' => $request->tgl,
            'imgProfile' => $gambarUrl,
        ];


        $this->Akun->addData($data);

        return redirect()->route('akun.support', ['alert' => 'success']);
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
            return redirect()->route('akun.support')->with('error', 'Akun tidak ditemukan.');
        }

        return view('Support.edit', [
            'akun' => $akun,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, $username){
    $akun = Akun::where('username', $username)->first();

    if (!$akun) {
        return redirect()->route('akunadmin')->with('error', 'Akun tidak ditemukan.');
    }

    // ✅ Validasi input
    $request->validate([
        'nama' => 'required|max:150',
        'email' => 'required|email',
        'nohp' => 'required|max:20',
        'role' => 'required',
        'upload' => 'nullable|mimes:jpg,jpeg,png,gif|max:5120'
    ]);

    // ✅ Update gambar jika ada
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

    // ✅ Update data lain
    $akun->name = $request->nama;
    $akun->email = $request->email;
    $akun->nohp = $request->nohp;
    $akun->idRole = $request->role;

    $akun->save();

    return redirect()->route('akunadmin')->with('success', 'Data berhasil diperbarui.');
}
}
