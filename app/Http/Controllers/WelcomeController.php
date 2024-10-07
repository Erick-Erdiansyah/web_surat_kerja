<?php

namespace App\Http\Controllers;

use App\Models\LaporanSK;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $laporans = LaporanSK::with(['kategori', 'sub_kategori'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('sub_kategori', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            })
            ->get()
            ->map(function ($laporan) {
                $laporan->created_human = Carbon::parse($laporan->created_at)->locale('id')->diffForHumans();
                $laporan->created_timestamp = $laporan->created_at->timestamp;
                return $laporan;
            });
        return Inertia::render('Landing/Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'Laporans' => $laporans,
            'filters' => $request->only(['search']),
        ]);
    }
}
