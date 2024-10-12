<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index(){
        $user = Auth::user();

        $unreadNotifications = $user->unreadNotifications;

        return Inertia::render('Layouts/AppLayout',compact($unreadNotifications));
    }
}
