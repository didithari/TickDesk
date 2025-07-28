<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    public function index()
    {
        return view('auth.forgotpass');
    }

    public function sendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $token = Password::createToken($user);

        // Send the custom email
        Mail::to($user->email)->send(new ResetPasswordMail($token, $user->email, $user->name));

        return back()->with('status', 'Link reset password telah dikirimkan ke email Anda.');
    }
}
