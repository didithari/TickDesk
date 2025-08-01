<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket; // Pastikan model ini sudah di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeveloperController extends Controller
{
    public function index()
    {

        $userId = Auth::id(); // Sesuaikan dengan Auth::id() jika diperlukan

        $user = DB::table('users')->where('id', $userId)->first();

        // Membuat instance dari SupportTicket
        $supportTicket = new SupportTicket();

        // Memanggil fungsi allWithDevRole pada instance
        $tickets = $supportTicket->allWithDevRole();

        // Mengirimkan data tiket yang sudah di-join ke view
        return view('Developer.developer', compact('tickets', 'user'));
    }
}
