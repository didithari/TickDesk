<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    // Tampilkan semua data role
    public function index()
    {
        $data = Role::all();
        return view('Role.role', ['roles' => $data]); // sesuaikan dengan view kamu
    }

    // Simpan data role baru
    public function store(Request $request)
    {
        $request->validate([
            'namaRole' => 'required|string|max:100'
        ]);

        Role::create([
            'namaRole' => $request->namaRole
        ]);

        return redirect()->back()->with('success', 'Role berhasil ditambahkan!');
    }

    // Update data role
    public function update(Request $request, $id)
    {
        $request->validate([
            'namaRole' => 'required|string|max:100'
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'namaRole' => $request->namaRole
        ]);

        return redirect()->back()->with('success', 'Role berhasil diupdate!');
    }

    // Hapus data role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->back()->with('success', 'Role berhasil dihapus!');
    }
}
