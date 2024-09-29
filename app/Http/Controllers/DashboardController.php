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

        // Fetch new items with relationships
        $newItems = LaporanSK::with(['kategori', 'sub_kategori'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->get();

        // Fetch bookmarked laporans with relationships
        $bookmarkedLaporans = $user->bookmarkedLaporans()->with(['kategori', 'sub_kategori'])->get();

        // Attach permissions to each new item
        $newItemsWithPermissions = $newItems->map(function ($item) use ($user) {
            return array_merge($item->toArray(), [
                'can' => [
                    'update' => $user->can('update', $item),
                    'delete' => $user->can('delete', $item),
                ],
            ]);
        });

        // Attach permissions to each bookmarked laporan
        $bookmarkedLaporanPermision = $bookmarkedLaporans->map(function ($item) use ($user) {
            return array_merge($item->toArray(), [
                'can' => [
                    'update' => $user->can('update', $item),
                    'delete' => $user->can('delete', $item),
                ],
            ]);
        });

        // Render the dashboard with the modified data
        return Inertia::render('Dashboard', [
            'newItems' => $newItemsWithPermissions,
            'bookmarkedLaporans' => $bookmarkedLaporanPermision,
        ]);
    }
}


