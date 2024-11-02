<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookmarkRequest;
use App\Http\Requests\UpdateBookmarkRequest;
use App\Models\Bookmark;
use App\Models\LaporanSK;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request  as HttpRequest;
use Inertia\Inertia;

class BookmarkController extends Controller
{
    public function index(HttpRequest $httpRequest)
    {
        $user = Auth::user();
        $bookmarkedLaporans = $user->bookmarkedLaporans()->get();
        // $bookmarkedLaporans = $user->bookmarkedLaporans()->pluck('laporan_s_k_s.id');

        if ($httpRequest->expectsJson()) {
            return response()->json([
                'bookmarkedLaporans' => $bookmarkedLaporans,
            ]);
        }

        return Inertia::render('Bookmarks', [
            'bookmarkedLaporans' => $bookmarkedLaporans,
        ]);
    }

    public function store(StoreBookmarkRequest $request)
    {
        Bookmark::updateOrCreate(
            ['user_id' => Auth::id(), 'laporan_id' => $request->laporan_id]
        );

        if ($request->expectsJson()) {
            return response()->json([], 201);
        }

        return back();
    }

    public function destroy(UpdateBookmarkRequest $request)
    {
        Bookmark::where('user_id', Auth::id())
            ->where('laporan_id', $request->laporan_id)
            ->delete();

        if ($request->expectsJson()) {
            return response()->json([], 201);
        }

        return back();
    }
}
