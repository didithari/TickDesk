<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewPasswordController extends Controller
{
    public function index()
    {
        return view('auth.changepass');
    }
}
