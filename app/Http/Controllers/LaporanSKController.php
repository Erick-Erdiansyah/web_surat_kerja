<?php

namespace App\Http\Controllers;

use App\Models\LaporanSK;
use App\Http\Requests\StoreLaporanSKRequest;
use App\Http\Requests\UpdateLaporanSKRequest;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\User;
use App\Notifications\NewLaporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LaporanSKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HttpRequest $request)
    {
        $user = Auth::user();

        $bookmarkedLaporans = $user->bookmarkedLaporans()->pluck('laporan_s_k_s.id');

        if ($request->expectsJson()) {
            return response()->json([
                'laporans' => LaporanSK::with(['kategori', 'sub_kategori'])
                    ->when(Request::input('search'), function ($query, $search) {
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
                    ->when(Request::input('jenis'), function ($query, $jenis) {
                        if ($jenis !== 'all' && $jenis !== '') {
                            $query->where('jenis', 'like', "%{$jenis}%");
                        }
                    })
                    ->when(Request::input('kategori'), function ($query, $kategori) {
                        if ($kategori !== 'all' && $kategori !== '') {
                            $query->whereHas('kategori', function ($q) use ($kategori) {
                                $q->where('nama', 'like', "%{$kategori}%");
                            });
                        }
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10)
                    ->withQueryString()
                    ->through(fn($laporan) => [
                        'id' => $laporan->id,
                        'judul' => $laporan->judul,
                        'kategori' => $laporan->kategori ? $laporan->kategori : 'N/A',
                        'sub_kategori' => $laporan->sub_kategori ? $laporan->sub_kategori : 'N/A',
                        'isBookmarked' => $bookmarkedLaporans->contains($laporan->id),
                        'created_human' => Carbon::parse($laporan->created_at)->locale('id')->diffForHumans(),
                        'created_timestamp' => $laporan->created_at->timestamp,
                        'surat_file' => $laporan->surat_file,
                        'can' => [
                            'update' => Auth::user()->can('update', $laporan),
                            'delete' => Auth::user()->can('delete', $laporan),
                        ]
                    ]),
                'search' => Request::only(['search']),
                'jenis' => Request::only(['jenis']),
                'kategori' => Request::only(['kategori']),
                'bookmarkedLaporans' => $bookmarkedLaporans,
                'can' => [
                    'create' => Auth::user()->can('create', LaporanSK::class),
                ]
            ]);
        }

        return Inertia::render('Surat/Index', [
            'laporans' => LaporanSK::with(['kategori', 'sub_kategori'])
                ->when(Request::input('search'), function ($query, $search) {
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
                ->when(Request::input('jenis'), function ($query, $jenis) {
                    if ($jenis !== 'all' && $jenis !== '') {
                        $query->where('jenis', 'like', "%{$jenis}%");
                    }
                })
                ->when(Request::input('kategori'), function ($query, $kategori) {
                    if ($kategori !== 'all' && $kategori !== '') {
                        $query->whereHas('kategori', function ($q) use ($kategori) {
                            $q->where('nama', 'like', "%{$kategori}%");
                        });
                    }
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($laporan) => [
                    'id' => $laporan->id,
                    'judul' => $laporan->judul,
                    'kategori' => $laporan->kategori ? $laporan->kategori : 'N/A',
                    'sub_kategori' => $laporan->sub_kategori ? $laporan->sub_kategori : 'N/A',
                    'isBookmarked' => $bookmarkedLaporans->contains($laporan->id),
                    'created_human' => Carbon::parse($laporan->created_at)->locale('id')->diffForHumans(),
                    'created_timestamp' => $laporan->created_at->timestamp,
                    'surat_file' => $laporan->surat_file,
                    'can' => [
                        'update' => Auth::user()->can('update', $laporan),
                        'delete' => Auth::user()->can('delete', $laporan),
                    ]
                ]),
            'search' => Request::only(['search']),
            'jenis' => Request::only(['jenis']),
            'kategori' => Request::only(['kategori']),
            'bookmarkedLaporans' => $bookmarkedLaporans,
            'can' => [
                'create' => Auth::user()->can('create', LaporanSK::class),
            ]
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(HttpRequest $request)
    {
        $Kategories = Kategori::all();
        $SubKategories = SubKategori::all();
        $Jurusan = Jurusan::all();

        if ($request->expectsJson()) {
            return response()->json([
                'Kategories' => $Kategories,
                'SubKategories' => $SubKategories,
                'Jurusan' => $Jurusan
            ]);
        }

        return Inertia::render('Surat/Partials/Form', compact('Kategories', 'SubKategories', 'Jurusan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLaporanSKRequest $request)
    {
        // Validation
        $validatedData = $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'sub_kategori_id' => 'required|exists:sub_kategoris,id',
            'jenis' => 'required|in:surat kerja,surat tugas',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tahun_ajaran' => 'required|string|max:20',
            'surat_file' => 'required|file|max:2048',
        ]);

        $filePath = $request->file('surat_file')->store('surat_files', 'public');

        // Merge file path
        $validatedData['surat_file'] = $filePath;

        // Create Laporan SK
        $laporan = LaporanSK::create($validatedData);

        $users = User::all();

        $users->each->notify(new NewLaporan($laporan));

        $request->session()->flash('flash.banner', 'Yay it works! I guess');
        $request->session()->flash('flash.bannerStyle', 'success');

        if ($request->expectsJson()) {
            return response()->json([], 200);
        }

        return redirect()->route('index')->banner("I haven't test it . sleepy zzzzzz");
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanSK $Surat, HttpRequest $request)
    {
        $user = Auth::user();

        $bookmarkedLaporans = $user->bookmarkedLaporans()->pluck('laporan_s_k_s.id');

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanSK $Surat, Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'laporan' => $Surat,
                'Jurusan' => Jurusan::all(),
                'Kategories' => Kategori::all(),
                'SubKategories' => SubKategori::all(),
            ]);
        }

        return Inertia::render('Surat/Partials/Form', [
            'laporan' => $Surat,
            'Jurusan' => Jurusan::all(),
            'Kategories' => Kategori::all(),
            'SubKategories' => SubKategori::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanSKRequest $request, LaporanSK $Surat)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'sub_kategori_id' => 'required|exists:sub_kategoris,id',
            'jenis' => 'required|in:surat kerja,surat tugas',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tahun_ajaran' => 'required|string|max:20',
            'surat_file' => 'nullable|file|max:10240',
        ]);

        // dd($validatedData);

        if ($request->hasFile('surat_file')) {
            $filePath = $request->file('surat_file')->store('surat_files', 'public');
            $validatedData['surat_file'] = $filePath;
        } else {
            unset($validatedData['surat_file']);
        }

        // dd($validatedData);

        $Surat->update($validatedData);

        session()->flash('flash.banner', 'surat berhasil diperbaharui');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->expectsJson()) {
            return response()->json([], 201);
        }

        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanSK $Surat, HttpRequest $request)
    {
        $Surat->delete();

        if ($request->expectsJson()) {
            return response()->json([], 200);
        }

        return back();
    }

    public function downloadFile($filename)
    {
        $file = public_path("storage/surat_files/$filename");

        // Check if the file exists
        if (!file_exists($file)) {
            abort(404, 'File not found');
        }

        // Return the file download response
        return response()->download($file);
    }
}
