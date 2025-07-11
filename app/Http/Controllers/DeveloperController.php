<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index()
    {
        $tickets = [
            ['id' => '001', 'type' => 'web', 'title' => 'Payment Gateway Error', 'name' => 'Sarah Wilson', 'time' => '2 hours ago'],
            ['id' => '002', 'type' => 'mobile', 'title' => 'App Crashes on iOS 17', 'name' => 'Mike Johnson', 'time' => '4 hours ago'],
            ['id' => '003', 'type' => 'desktop', 'title' => 'Performance Issues on Windows', 'name' => 'Emma Davis', 'time' => '6 hours ago'],
            ['id' => '004', 'type' => 'web', 'title' => 'Database Connection Timeout', 'name' => 'Alex Chen', 'time' => '8 hours ago'],
            ['id' => '005', 'type' => 'mobile', 'title' => 'Login Button Not Responding', 'name' => 'Liam Brown', 'time' => '1 day ago'],
            ['id' => '006', 'type' => 'desktop', 'title' => 'Software Update Failed', 'name' => 'Olivia Martin', 'time' => '2 days ago'],
            ['id' => '007', 'type' => 'web', 'title' => 'CSS Not Loading Properly', 'name' => 'Noah Smith', 'time' => '3 days ago'],
            ['id' => '008', 'type' => 'mobile', 'title' => 'Push Notification Delay', 'name' => 'Emma Wilson', 'time' => '4 days ago'],
            ['id' => '009', 'type' => 'desktop', 'title' => 'Application Freezes on Startup', 'name' => 'Mason Clark', 'time' => '5 days ago'],
            ['id' => '010', 'type' => 'web', 'title' => 'SEO Metadata Missing', 'name' => 'Ava Thomas', 'time' => '6 days ago'],
            ['id' => '011', 'type' => 'mobile', 'title' => 'Camera Access Denied on Android', 'name' => 'Ethan Harris', 'time' => '1 week ago'],
            ['id' => '012', 'type' => 'desktop', 'title' => 'Settings Panel Not Saving', 'name' => 'Isabella Lewis', 'time' => '1 week ago'],
            ['id' => '013', 'type' => 'web', 'title' => 'Broken Link on Homepage', 'name' => 'James Walker', 'time' => '8 days ago'],
            ['id' => '014', 'type' => 'mobile', 'title' => 'App Icon Missing on iOS', 'name' => 'Sophia Young', 'time' => '9 days ago'],
            ['id' => '015', 'type' => 'desktop', 'title' => 'Crash After Login', 'name' => 'Benjamin Hall', 'time' => '10 days ago'],
        ];

        return view('Developer.developer', compact('tickets'));
    }
}
