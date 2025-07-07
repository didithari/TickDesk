<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Akun;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AkunAdminController extends Controller
{
    
    public function __construct(){
        // auth
        // $this->middleware('auth');
        $this ->Akun = new Akun();
        $this ->Role = new Role();
    }

    public function index(){

        $alldata = [
            'alldata'=>$this->Akun->alldatad(),
            // 'datarole'=>$this->Role->alldata(),
        ];
        return view('Admin.akun', $alldata);
    }


    public function save(){
            // Validasi input
            Request()->validate([
                'username' => 'required|max:255',
                'nama' => '|max:150',
                'role' => '',
                'pass' => '',
                'status' => '',
                'tgl' => '',
                'upload' => 'mimes:jpg,png,JPEG,gif|max:5120', // Menambahkan validasi untuk jenis file gambar dan maksimum ukuran file
            ], [
                'username.max' => 'Panjang maksimum untuk user adalah 255 karakter.',
                'upload.max' => 'Ukuran maksimum file gambar adalah 5MB.',
            ]);
            
            // Inisialisasi variabel untuk menyimpan URL gambar
            $gambarUrl = null;
    
            // Cek apakah ada file gambar yang diunggah
            if (request()->hasFile('upload')) {
                $gambar = request()->file('upload'); // Mengambil file gambar dari request
                $ekstensi = $gambar->getClientOriginalExtension();
                // Membuat nama file yang unik dengan menambahkan tanggal saat ini (tahun-bulan-hari)
                $namaGambar = date('Ymd') . '_' . uniqid() . '.' . $ekstensi;
                $gambar->move(public_path('GambarProfileAdmin/'), $namaGambar); // Memindahkan file gambar ke folder yang ditentukan
                $gambarUrl = asset('GambarProfileAdmin/' . $namaGambar); // Menghasilkan URL gambar
            }
            
            // Data yang akan disimpan
            $data = [
                'username' => request()->username,
            // 'password' => Hash::make(request()->pass), // buat enkripsi hash
                'password' => request()->pass,
                'name' => request()->nama,
                'status' => 'Away',
                'lvlAkun' => '1',
                'idRole' => request()->role,
                'created_at' => request()->tgl,
                'imgProfile' => $gambarUrl, // Menggunakan URL gambar jika ada, jika tidak tetap null
            ];
            
            // Menyimpan data ke database
            $this->Akun->addData($data);
            return redirect()->route('akunadmin', ['akunadmin' => 'success']); // Menggunakan with() untuk mengirim pesan flash
        
    }
    

    // public function editakunuser($user){
    //     if(!session('login')){
    //         return redirect('/');
    //     }else{
    //     $data = [
    //         'main'=>$this->Akun->editakunuser($user),
    //     ];
    //     return view('akun.edituser', $data);
    // }
    // }


    // public function update(Request $request, $user)
    // {
    //     $Akun = $this->Akun->find($user);

    //     if (!$Akun) {
    //         return redirect()->route('admin')->with('error', 'Data tidak ditemukan');
    //     }

    //     // Validasi input
    //     $request->validate([
    //         'nama' => 'required|max:50',
    //         'email' => 'required|email|max:50',
    //         'nohp' => 'required|max:50',
    //         'pass' => '',
    //         'lokasi' => 'required',
    //         'upload' => 'mimes:jpg,png,jpeg,gif|max:5120',
    //     ], [
    //         'upload.max' => 'Ukuran maksimum file gambar adalah 5MB.',
    //     ]);

    //     // Periksa apakah ada file gambar yang diunggah
    //     if ($request->hasFile('upload')) {
    //         // Menghapus gambar lama jika ada
    //         if ($Akun->gambar) {
    //             $gambarPath = public_path('dataprofile/' . basename($Akun->gambar));
    //             if (file_exists($gambarPath)) {
    //                 unlink($gambarPath);
    //             }
    //         }

    //         $gambar = $request->file('upload');
    //         $ekstensi = $gambar->getClientOriginalExtension();
    //         $namaGambar = date('Ymd') . '_' . uniqid() . '.' . $ekstensi;
    //         $gambar->move(public_path('dataprofile/'), $namaGambar);
    //         $gambarUrl = asset('dataprofile/' . $namaGambar);

    //         // Perbarui data gambar di database
    //         $Akun->gambar = $gambarUrl;
    //     }

    //     // Perbarui data lainnya
    //     $Akun->nama = $request->nama;
    //     $Akun->email = $request->email;
    //     $Akun->nohp = $request->nohp;
    //     $Akun->pass = $request->pass;
    //     $Akun->lokasi = $request->lokasi;

    //     $Akun->save();

    //     return redirect()->route('admin')->with('success', 'Data berhasil diperbarui');
    // }


    public function hapusData($username){
        // if(!session('login')){
        //     return redirect('/');
        // }else{
        $akun = akunuser::where('username', $username)->first();
        if ($akun) {
            try {
                $namaGambar = basename($akun->gambar);
    
                // Hapus gambar terkait
                $gambarPath = public_path('GambarProfile/' . $namaGambar);
                if (file_exists($gambarPath)) {
                    unlink($gambarPath);
                }
    
                // Hapus data pengguna dari database
                $akun->delete();
    
                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Data tidak dapat dihapus karena berelasi dengan Data Lainnya!']);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'Data tidak ditemukan!']);
        }
    // }
}
    
    
    
    // ADMIN

// public function updateadmin(Request $request, $user){
//         if(!session('login')){
//             return redirect('/');
//         } else {

//         $Akun = $this->Akun->find($user);

//         if (!$Akun) {
//             return redirect()->route('admin')->with('error', 'Data tidak ditemukan');
//         }

//         // Validasi input
//         $request->validate([
//             'nama' => 'required|max:50',
//             'email' => 'required|email|max:50',
//             'nohp' => 'required|max:50',
//             'pass' => '',
//             'lokasi' => 'required',
//             // 'level' => 'required',
//             // 'tgl' => 'required',
//             'upload' => 'mimes:jpg,png,JPEG,gif|max:5120', // Menambahkan validasi untuk jenis file gambar dan maksimum ukuran file
//         ], [
//             'upload.max' => 'Ukuran maksimum file gambar adalah 5MB.',
//         ]);

//         // Periksa apakah ada file gambar yang diunggah
//         if ($request->hasFile('upload')) {
//             // Menghapus gambar lama jika ada
//             $namaGambar = basename($Akun->gambar);
    
//             // Hapus gambar terkait
//             $gambarPath = public_path('dataprofile/' . $namaGambar);
//             if (file_exists($gambarPath)) {
//                 unlink($gambarPath);
//             }

//             $gambar = $request->file('upload'); // Mengambil file gambar dari request
//             $ekstensi = $gambar->getClientOriginalExtension();
//             // Membuat nama file yang unik dengan menambahkan tanggal saat ini (tahun-bulan-hari)
//             $namaGambar = date('Ymd') . '_' . uniqid() . '.' . $ekstensi;
//             $gambar->move(public_path('dataprofile/'), $namaGambar); // Memindahkan file gambar ke folder yang ditentukan
//             $gambarUrl = asset('dataprofile/' . $namaGambar); // Menghasilkan URL gambar

//             // Perbarui data gambar di database
//             $Akun->gambar = $gambarUrl;
//         }

//         // Perbarui data lainnya
//         $Akun->nama = $request->nama;
//         $Akun->email = $request->email;
//         $Akun->nohp = $request->nohp;
//         // $Akun->pass = Hash::make($request->pass);
//         $Akun->lokasi = $request->lokasi;
//         // $Akun->level = 'Petani';
//         // $Akun->tanggal_create = $request->tgl;
//         $Akun->save();

//         return redirect()->route('admin')->with('success', 'Data berhasil diperbarui');
//     }
// }

    
}
