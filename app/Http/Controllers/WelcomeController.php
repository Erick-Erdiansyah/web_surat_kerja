<?php

namespace App\Http\Controllers;

use App\Models\LaporanSK;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $bookmarkedLaporans = $user ? $user->bookmarkedLaporans()->pluck('laporan_s_k_s.id') : collect();

        // Fetch laporans dari method private, kenapa ? biar nggak ngulang manggilnya
        $laporans = $this->getLaporans($request, $bookmarkedLaporans);

        if ($request->expectsJson()) {
            return response()->json([
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'laravelVersion' => Application::VERSION,
                'phpVersion' => PHP_VERSION,
                'laporans' => $laporans,
                'filters' => $request->only(['search']),
                'bookmarkedLaporans' => $bookmarkedLaporans,
            ]);
        }

        return Inertia::render('Landing/Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'laporans' => $laporans,
            'filters' => $request->only(['search']),
            'bookmarkedLaporans' => $bookmarkedLaporans,
        ]);
    }

    private function getLaporans(Request $request, $bookmarkedLaporans)
    {
        return LaporanSK::with(['kategori', 'sub_kategori'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('jenis', 'like', "%{$search}%")
                        ->orWhereHas('kategori', function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%");
                        })
                        ->orWhereHas('sub_kategori', function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($laporan) use ($bookmarkedLaporans) {
                return [
                    'id' => $laporan->id,
                    'judul' => $laporan->judul,
                    'kategori' => $laporan->kategori ?? 'N/A',
                    'sub_kategori' => $laporan->sub_kategori ?? 'N/A',
                    'isBookmarked' => $bookmarkedLaporans->contains($laporan->id),
                    'created_human' => Carbon::parse($laporan->created_at)->locale('id')->diffForHumans(),
                    'created_timestamp' => $laporan->created_at->timestamp,
                    'surat_file' => $laporan->surat_file,
                    'can' => [
                        'update' => Auth::check() && Auth::user()->can('update', $laporan),
                        'delete' => Auth::check() && Auth::user()->can('delete', $laporan),
                    ],
                ];
            });
    }
    public function show(LaporanSK $Surat, Request $request)
    {
        $user = Auth::user();
        $bookmarkedLaporans = $user ? $user->bookmarkedLaporans()->pluck('laporan_s_k_s.id') : collect();

        if ($request->expectsJson()) {
            return response()->json([
                'laporan' => $Surat,
                'kategori' => $Surat->kategori ? $Surat->kategori->nama : 'N/A',
                'sub_kategori' => $Surat->sub_kategori ? $Surat->sub_kategori->nama : 'N/A',
                'bookmarkedLaporans' => $bookmarkedLaporans,
            ]);
        }

        return Inertia::render('Surat/Read', [
            'laporan' => $Surat,
            'kategori' => $Surat->kategori ? $Surat->kategori->nama : 'N/A',
            'sub_kategori' => $Surat->sub_kategori ? $Surat->sub_kategori->nama : 'N/A',
            'bookmarkedLaporans' => $bookmarkedLaporans,
        ]);
    }

}
