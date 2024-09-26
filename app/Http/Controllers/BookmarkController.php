<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookmarkRequest;
use App\Http\Requests\UpdateBookmarkRequest;
use App\Models\Bookmark;
use App\Models\LaporanSK;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookmarkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookmarkedLaporans = $user->bookmarkedLaporans()->get();
        // $bookmarkedLaporans = $user->bookmarkedLaporans()->pluck('laporan_s_k_s.id');

        return Inertia::render('Bookmarks', [
            'bookmarkedLaporans' => $bookmarkedLaporans,
        ]);
    }

    public function store(StoreBookmarkRequest $request)
    {
        // Validation is handled by the form request, so no need to validate again here
        Bookmark::updateOrCreate( // Using the singular form of the model name
            ['user_id' => Auth::id(), 'laporan_id' => $request->laporan_id]
        );

        return back();
    }

    public function destroy(UpdateBookmarkRequest $request)
    {
        // Validation is handled by the form request, so no need to validate again here
        Bookmark::where('user_id', Auth::id())
            ->where('laporan_id', $request->laporan_id)
            ->delete();

        return back();
    }
}
