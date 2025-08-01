<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class NewPasswordController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->route()->parameter('token');
        return view('auth.changepass', ['token' => $token, 'email' => $request->email]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ], [
            'password.required' => 'Mohon isi password baru Anda.',
            'password.confirmed' => 'Kedua password tersebut tidak sama.'
        ]);

        $resetter = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetter || !Hash::check($request->token, $resetter->token)) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah kedaluwarsa.']);
        }

        $akun = User::where('email', $request->email)->first();
        if (!$akun) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $akun->password = Hash::make($request->password);
        $akun->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil diubah.');
    
    }
}
