<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatDevController extends Controller
{
   public function index(Request $request)
{
    $userId = Auth::id(); // Ambil user id dari session
    $user = Auth::user(); // Ambil user object dari session

    // Mengambil semua tiket yang terkait dengan developer
    $tickets = DB::table('devTickets')
        ->join('users AS support', 'devTickets.supportID', '=', 'support.id')
        ->join('users AS developer', 'devTickets.devID', '=', 'developer.id')
        ->where('devTickets.devID', '=', $userId)
        ->select(
            'devTickets.id',
            'devTickets.title',
            'devTickets.status',
            'devTickets.created_at',
            'support.name AS support_name',
            'support.profile_picture AS support_avatar',
            'support.email AS support_email',
            'developer.email AS developer_email',
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
            'devAttachments.filePath AS chat_image',
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
        // Cek apakah ada attachment
        $isImage = in_array(strtolower($msg->attachment_extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
        $attachment = null;
        if ($msg->chat_image) {
            if ($isImage) {
                $attachment = [
                    'type' => 'image',
                    'url' => $msg->chat_image,
                    'name' => basename($msg->chat_image),
                ];
            } else {
                // Untuk file selain gambar, gunakan link download
                $attachment = [
                    'type' => 'file',
                    'url' => asset('storage/' . $msg->chat_image),
                    'name' => basename($msg->chat_image),
                ];
            }
        }

        $selectedTicket->messages->push([
            'sender' => $msg->sender,
            'avatar' => $msg->sender === 'support' ? $selectedTicket->support_avatar : $selectedTicket->developer_avatar,
            'message' => $msg->chat_message,
            'time' => $msg->chat_time,
            'attachment' => $attachment,
        ]);
    }
    return view('Chatdev.chatdev', compact('selectedTicket', 'tickets', 'user'));
}

    public function store(Request $request)
    {
        $userId = "3"; // Sesuaikan dengan Auth::id() jika diperlukan
        $ticketId = $request->get('ticket'); // Mengambil ticket ID dari request
        $message = $request->input('message'); // Pesan yang dikirim
        $chatCreated = DB::table('devTickets')->where('id', $ticketId)->value('created_at');
        $datePrefix = 'TK-' . \Carbon\Carbon::parse($chatCreated)->format('Ymd');


        // Validasi input message
        if (!$message && !$request->hasFile('attachment') && !$request->hasFile('image')) {
            return back()->with('error', 'Message cannot be empty.');
        }

        // Menyimpan pesan ke database
        $chatId = DB::table('devChats')->insertGetId([
            'ticket_id' => $ticketId,
            'sender' => 'dev', // 'support' bisa diganti sesuai dengan role yang sedang mengirim
            'response' => $message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Menangani file upload jika ada
        if ($request->hasFile('attachment')) {
            // Hitung total attachment yang sudah ada untuk tiket ini
            $attachmentCount = DB::table('devAttachments')
                ->join('devChats', 'devAttachments.chatID', '=', 'devChats.id')
                ->where('devChats.ticket_id', $ticketId)
                ->count();

            foreach ($request->file('attachment') as $idx => $file) {
                $newFileName = $datePrefix . "-" . $ticketId . '_' . ($attachmentCount + $idx + 1) . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('chat_attachments', $newFileName, 'public');

                DB::table('devAttachments')->insert([
                    'chatID' => $chatId,
                    'fileName' => $newFileName,
                    'filePath' => $filePath,
                    'fileExtension' => $file->getClientOriginalExtension(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        if ($request->hasFile('image')) {
            // Hitung total image yang sudah ada untuk tiket ini
            $imageCount = DB::table('devAttachments')
                ->join('devChats', 'devAttachments.chatID', '=', 'devChats.id')
                ->where('devChats.ticket_id', $ticketId)
                ->whereIn('devAttachments.fileExtension', ['jpg','jpeg','png','gif','bmp','webp'])
                ->count();

            foreach ($request->file('image') as $idx => $gambar) {
                $namaGambar = $datePrefix . "-" . $ticketId . '_' . ($imageCount + $idx + 1) . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path('chat_images/'), $namaGambar);   
                $gambarUrl = asset('chat_images/' . $namaGambar);

                DB::table('devAttachments')->insert([
                    'chatID' => $chatId,
                    'fileName' => $namaGambar,
                    'filePath' => $gambarUrl,
                    'fileExtension' => $gambar->getClientOriginalExtension(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        // Redirect kembali ke halaman tiket dengan pesan sukses
        return redirect()->route('Chatdev.chatdev', ['ticket' => $ticketId])
                         ->with('success', 'Message sent successfully.');
    }
}