<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SPVTicketController extends Controller
{
    public function index(Request $request)
    {
        $faker = \Faker\Factory::create();

        $roles = ['Mobile Dev', 'Web Dev', 'Desktop Dev'];
        $statuses = ['Open', 'In Progress', 'Resolved'];
        $titles = [
            'Login Issue Crashes App',
            'Payment Gateway Error',
            'UI Misalignment in Header',
            'Export to PDF Not Working',
            'Slow Loading Dashboard',
            'Notification Not Received',
            'App Freezes on Submit',
            'Dark Mode Bug',
            'Wrong User Role Assigned',
            'Data Not Synced',
            'Broken Link in Footer',
            'File Upload Fails',
            'Search Not Working',
            'Crash on Android 14',
            'API Timeout Error',
            'Pagination Broken',
            'Push Notification Broken',
            'Unresponsive Sidebar',
            'Broken Profile Picture Upload',
            'Email Verification Bug'
        ];

        $tickets = collect([]);
        for ($i = 1; $i <= 20; $i++) {
            $tickets->push([
                'code' => 'TK' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'role' => $roles[array_rand($roles)],
                'status' => $statuses[array_rand($statuses)],
                'title' => $titles[array_rand($titles)],
                'user' => $faker->name,
                'submitted_at' => Carbon::now()->subHours(rand(1, 48)),
            ]);
        }

        // Statistik tetap dihitung semua status
        $stats = [
            'total' => $tickets->count(),
            'open' => $tickets->where('status', 'Open')->count(),
            'in_progress' => $tickets->where('status', 'In Progress')->count(),
            'resolved' => $tickets->where('status', 'Resolved')->count(),
        ];

        // Kirim hanya tiket Open & In Progress ke tampilan
        $visibleTickets = $tickets->whereIn('status', ['Open', 'In Progress'])->values();

        return view('SPV.spv', [
            'tickets' => $visibleTickets,
            'stats' => $stats
        ]);
    }
}
