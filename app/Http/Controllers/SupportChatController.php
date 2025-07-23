<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupportChatController extends Controller
{
   public function index(Request $request)
{
    $userId = "2"; // Sesuaikan dengan Auth::id() jika diperlukan

    $user = DB::table('users')->where('id', $userId)->first();

    // Mengambil semua tiket yang terkait dengan developer
    $tickets = DB::table('devTickets')
        ->join('users AS support', 'devTickets.supportID', '=', 'support.id')
        ->join('users AS developer', 'devTickets.devID', '=', 'developer.id')
        ->where('devTickets.supportID', '=', $userId)
        ->select(
            'devTickets.id',
            'devTickets.title',
            'devTickets.status',
            'devTickets.created_at',
            'support.name AS support_name',
            'support.profile_picture AS support_avatar',
            'developer.name AS developer_name',
            'developer.profile_picture AS developer_avatar'
        )
        ->orderBy('devTickets.created_at', 'desc')
        ->get();

    // Check if any tickets were returned
    if ($tickets->isEmpty()) {
        return redirect()->route('ticket.index')->with('error', 'No tickets found.');
    }

    // Tentukan ticket ID yang pertama kali dipilih (jika tidak ada, pilih ticket pertama)
    $ticketId = $request->get('ticket', $tickets[0]->id);

    // Mengambil pesan-pesan terkait tiket yang dipilih
    $messages = DB::table('devChats')
        ->join('devTickets', 'devChats.ticket_id', '=', 'devTickets.id')
        ->leftJoin('devAttachments', 'devChats.id', '=', 'devAttachments.chatID')
        ->where('devTickets.id', '=', $ticketId)
        ->select(
            'devChats.sender',
            'devChats.response AS chat_message',
            'devChats.created_at AS chat_time',
            'devAttachments.fileName AS chat_image',
            'devAttachments.fileExtension AS attachment_extension'
        )
        ->orderBy('devChats.created_at', 'asc')
        ->get();

    // Menyiapkan data untuk UI
    $selectedTicket = $tickets->firstWhere('id', $ticketId);

    // Inisialisasi messages sebagai objek (bukan array)
    $selectedTicket->messages = collect(); // Menginisialisasi sebagai Collection

    // Menambahkan pesan chat ke data
    foreach ($messages as $msg) {
        $selectedTicket->messages->push([
            'sender' => $msg->sender,
            'avatar' => $msg->sender === 'support' ? $selectedTicket->support_avatar : $selectedTicket->developer_avatar,
            'message' => $msg->chat_message,
            'time' => $msg->chat_time,
            'image' => $msg->chat_image,
        ]);
    }

    return view('Chatsup.chatsup', compact('selectedTicket', 'tickets', 'user'));
}



    public function store(Request $request)
    {
        $userId = "3"; // Sesuaikan dengan Auth::id() jika diperlukan
        $ticketId = $request->get('ticket'); // Mengambil ticket ID dari request
        $message = $request->input('message'); // Pesan yang dikirim

        // Validasi input message
        if (!$message) {
            return back()->with('error', 'Message cannot be empty.');
        }

        // Menyimpan pesan ke database
        $chatId = DB::table('devChats')->insertGetId([
            'ticket_id' => $ticketId,
            'sender' => 'support', // 'support' bisa diganti sesuai dengan role yang sedang mengirim
            'response' => $message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Menangani file upload jika ada
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store('chat_attachments', 'public'); // Menyimpan file di folder public/chat_attachments

            // Menyimpan informasi lampiran ke database
            DB::table('devAttachments')->insert([
                'chatID' => $chatId,
                'fileName' => $file->getClientOriginalName(),
                'filePath' => $filePath,
                'fileExtension' => $file->getClientOriginalExtension(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('chat_images', options: 'public'); // Menyimpan gambar di folder public/chat_images

            // Menyimpan informasi gambar ke database
            DB::table('devAttachments')->insert(values: [
                'chatID' => $chatId,
                'fileName' => $image->getClientOriginalName(),
                'filePath' => $imagePath,
                'fileExtension' => $image->getClientOriginalExtension(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Redirect kembali ke halaman tiket dengan pesan sukses
        return redirect()->route('Chatsup.chatsup', parameters: ['ticket' => $ticketId])
                         ->with('success', 'Message sent successfully.');
    }
}
