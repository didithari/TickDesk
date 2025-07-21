<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DevRole;

class RoleController extends Controller
{
    // Tampilkan semua data dev role
    public function index()
    {
        $data = DevRole::all();
        return view('Role.role', ['roles' => $data]); // Sesuaikan dengan view yang Anda gunakan
    }

    // Simpan data dev role baru
    public function store(Request $request)
    {
        $request->validate([
            'roleName' => 'required|string|max:100'
        ]);

        DevRole::create([
            'roleName' => $request->roleName
        ]);

        return redirect()->back()->with('success', 'Dev Role berhasil ditambahkan!');
    }

    // Update data dev role
    public function update(Request $request, $id)
    {
        $request->validate([
            'roleName' => 'required|string|max:100'
        ]);

        $role = DevRole::findOrFail($id);
        $role->update([
            'roleName' => $request->roleName
        ]);

        return redirect()->back()->with('success', 'Dev Role berhasil diupdate!');
    }

    // Hapus data dev role
    public function destroy($id)
    {
        $role = DevRole::findOrFail(id: $id);
        $role->delete();

        return redirect()->back()->with('success', 'Dev Role berhasil dihapus!');
    }
}
