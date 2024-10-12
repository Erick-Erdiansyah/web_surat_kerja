<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $unreadNotifications = $user->unreadNotifications;

        return response()->json([
            'unreadNotifications' => $unreadNotifications,
        ]);
    }


    public function markRead(string $notifId)
    {
        $user = Auth::user();

        $notification = $user->notifications()->where('id', $notifId)->firstOrFail();

        $notification->markAsRead();

        return response()->json(['success' => true]); // Return JSON response
    }


}
