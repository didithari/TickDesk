<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportChatController extends Controller
{
    public function index()
    {
        return redirect()->route('Chatsup.chatsup.show', 1); // default ke tiket pertama
    }

    public function show($id)
    {
        $user = [
            'name' => 'John Doe',
            'role' => 'Support',
            'avatar' => 'https://i.pravatar.cc/40?img=10',
        ];

        $tickets = [
            1 => [
                'code' => '#TK-2025-001',
                'title' => 'Login Issue with Dashboard',
                'user' => 'Sarah Johnson',
                'time' => '2 hours ago',
                'status' => 'In Progress',
            ],
            2 => [
                'code' => '#TK-2025-002',
                'title' => 'Email Notification Not Working',
                'user' => 'Mike Chen',
                'time' => '1 day ago',
                'status' => 'In Progress',
            ],
            3 => [
                'code' => '#TK-2025-003',
                'title' => 'Payment Gateway Error',
                'user' => 'Emma Wilson',
                'time' => '2 days ago',
                'status' => 'In Progress',
            ]
        ];

        $messages = [
            1 => [
                ['from' => 'Sarah Johnson', 'avatar' => 'https://i.pravatar.cc/40?img=5', 'message' => "Hi, I'm having trouble logging in...", 'time' => '2:30 PM', 'side' => 'left'],
                ['from' => 'John Doe', 'avatar' => $user['avatar'], 'message' => "Hello Sarah! I'm sorry to hear that. Can you tell me the error you're seeing?", 'time' => '2:32 PM', 'side' => 'right'],
                ['from' => 'Sarah Johnson', 'avatar' => 'https://i.pravatar.cc/40?img=5', 'message' => "It says 'Invalid credentials' but I'm sure the password is correct.", 'time' => '2:33 PM', 'side' => 'left'],
                ['from' => 'John Doe', 'avatar' => $user['avatar'], 'message' => "Alright, have you recently changed your password?", 'time' => '2:34 PM', 'side' => 'right'],
                ['from' => 'Sarah Johnson', 'avatar' => 'https://i.pravatar.cc/40?img=5', 'message' => "No, not in the last few weeks.", 'time' => '2:35 PM', 'side' => 'left'],
                ['from' => 'John Doe', 'avatar' => $user['avatar'], 'message' => "Let me try resetting your session. One moment...", 'time' => '2:36 PM', 'side' => 'right'],
                ['from' => 'John Doe', 'avatar' => $user['avatar'], 'message' => "Okay, please try to login now using the same credentials.", 'time' => '2:38 PM', 'side' => 'right'],
                ['from' => 'Sarah Johnson', 'avatar' => 'https://i.pravatar.cc/40?img=5', 'message' => "Still not working, unfortunately.", 'time' => '2:39 PM', 'side' => 'left'],
                ['from' => 'John Doe', 'avatar' => $user['avatar'], 'message' => "Do you have access to your recovery email? I can send a reset link.", 'time' => '2:40 PM', 'side' => 'right'],
                ['from' => 'Sarah Johnson', 'avatar' => 'https://i.pravatar.cc/40?img=5', 'message' => "Yes, please send it.", 'time' => '2:41 PM', 'side' => 'left'],
                ['from' => 'John Doe', 'avatar' => $user['avatar'], 'message' => "Sent. Check your email for a link to reset your password.", 'time' => '2:42 PM', 'side' => 'right'],
                ['from' => 'Sarah Johnson', 'avatar' => 'https://i.pravatar.cc/40?img=5', 'message' => "Got it. Trying now...", 'time' => '2:43 PM', 'side' => 'left'],
                ['from' => 'Sarah Johnson', 'avatar' => 'https://i.pravatar.cc/40?img=5', 'message' => "Okay, I can log in now. Thank you!", 'time' => '2:45 PM', 'side' => 'left'],
                ['from' => 'John Doe', 'avatar' => $user['avatar'], 'message' => "You're welcome! Let me know if you face any other issues.", 'time' => '2:46 PM', 'side' => 'right'],
                ['from' => 'Sarah Johnson', 'avatar' => 'https://i.pravatar.cc/40?img=5', 'message' => "Will do. Have a great day!", 'time' => '2:47 PM', 'side' => 'left'],
            ],
            2 => [
                ['from' => 'Mike Chen', 'avatar' => 'https://i.pravatar.cc/40?img=6', 'message' => "Email notifications are not sending.", 'time' => '11:00 AM', 'side' => 'left'],
                ['from' => 'John Doe', 'avatar' => $user['avatar'], 'message' => "Thanks Mike. I’ll look into the SMTP config.", 'time' => '11:02 AM', 'side' => 'right'],
            ],
            3 => [
                ['from' => 'Emma Wilson', 'avatar' => 'https://i.pravatar.cc/40?img=7', 'message' => "Payment failed for multiple users.", 'time' => '9:00 AM', 'side' => 'left'],
                ['from' => 'John Doe', 'avatar' => $user['avatar'], 'message' => "We’ll check payment gateway logs.", 'time' => '9:05 AM', 'side' => 'right'],
            ]
        ];

        return view('Chatsup.chatsup', [
            'user' => $user,
            'tickets' => $tickets,
            'activeTicket' => $tickets[$id],
            'messages' => $messages[$id],
            'activeId' => $id
        ]);
    }
}
