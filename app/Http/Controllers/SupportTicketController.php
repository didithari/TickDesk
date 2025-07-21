<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\SupportTicket;

class SupportTicketController extends Controller
{
    protected $SupportTicket;

    public function __construct()
    {
        $this->SupportTicket = new SupportTicket();
    }

    // Tampilkan semua tiket developer
    public function index()
    {
        $data = [
            'alldata' => $this->SupportTicket->allData(),
        ];
        return view('SupportTicket.data', $data);
    }
    
}
