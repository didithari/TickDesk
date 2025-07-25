<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        $user = DB::table('users')
        ->where('email' ,'=', $request->email)
        ->first();

        if ($user && $request->password === $user->password) {
            switch ($user->privLevel) {
                //case 'admin': //NOT FINISHED
                //    return redirect('/admin/dashboard');
                //case 'super admin': NOT FINISHED
                //    return redirect('/superadmin/panel');
                case 'spv':
                    return redirect()->route('SPV.spv');
                case 'developer':
                    return redirect()->route('Developer.developer');
                case 'support':
                    return redirect()->route('Chatsup.chatsup');
                default:
                    return redirect('/')->withErrors(['Unauthorized role']);
            }
        }

        return back()->withErrors([
            'email' => 'Email Anda atau password Anda salah.',
        ]);
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login');
    }
}
