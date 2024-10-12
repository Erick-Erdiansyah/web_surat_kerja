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

        $bookmarkedLaporans = $user->bookmarkedLaporans()->with(['kategori', 'sub_kategori'])->get()
            ->map(function ($laporan) {
                return [
                    'id' => $laporan->id,
                    'judul' => $laporan->judul,
                    'kategori' => $laporan->kategori->nama ?? 'N/A',
                    'sub_kategori' => $laporan->sub_kategori->nama ?? 'N/A',
                    'created_human' => Carbon::parse($laporan->created_at)->locale('id')->diffForHumans(),
                    'created_timestamp' => $laporan->created_at->timestamp,
                    'surat_file' => $laporan->surat_file,
                    'can' => [
                        'update' => Auth::user()->can('update', $laporan),
                        'delete' => Auth::user()->can('delete', $laporan),
                    ],
                ];
            });

        return Inertia::render('Dashboard', [
            'bookmarkedLaporans' => $bookmarkedLaporans,
            'notif' => $user->unreadNotifications
        ]);
    }

}


