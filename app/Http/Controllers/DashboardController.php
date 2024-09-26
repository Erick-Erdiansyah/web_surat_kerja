<?php

namespace App\Http\Controllers;

use App\Models\LaporanSK;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch reports created in the last 7 days for the NewItem component
        $newItems = LaporanSK::with(['kategori', 'sub_kategori'])
        ->where('created_at', '>=', Carbon::now()
        ->subDays(7))
        ->get();

        // Fetch bookmarked reports for the Bookmarks component
        $bookmarkedLaporans = $user->bookmarkedLaporans()->with(['kategori', 'sub_kategori'])->get();

        return Inertia::render('Dashboard', [
            'newItems' => $newItems,
            'bookmarkedLaporans' => $bookmarkedLaporans,
        ]);
    }
}
