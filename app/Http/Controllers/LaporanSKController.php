<?php

namespace App\Http\Controllers;

use App\Models\LaporanSK;
use App\Http\Requests\StoreLaporanSKRequest;
use App\Http\Requests\UpdateLaporanSKRequest;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\SubKategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class LaporanSKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Surat/Index', [
            'Laporans' => LaporanSK::with(['kategori', 'sub_kategori'])
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhereHas('kategori', function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%");
                        })
                        ->orWhereHas('sub_kategori', function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%");
                        });
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn($laporan) => [
                    'id' => $laporan->id,
                    'judul' => $laporan->judul,
                    'kategori' => $laporan->kategori ? $laporan->kategori->nama : 'N/A',
                    'sub_kategori' => $laporan->sub_kategori ? $laporan->sub_kategori->nama : 'N/A',
                    'can' => [
                        'edit' => Auth::user()->can('edit', $laporan),
                    ]
                ]),
            'filters' => Request::only(['search']),
            'can' => [
                'createLaporan' => Auth::user()->can('create', LaporanSK::class),
            ]
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Kategories = Kategori::all();
        $SubKategories = SubKategori::all();
        $Jurusan = Jurusan::all();
        return Inertia::render('Surat/Create', compact('Kategories', 'SubKategories', 'Jurusan'));
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
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tahun_ajaran' => 'required|string|max:20',
            'surat_file' => 'required|file|max:2048',
        ]);

        // Handle file upload
        $filePath = $request->file('surat_file')->store('surat_files', 'public');

        // Merge file path
        $validatedData['surat_file'] = $filePath;

        LaporanSK::create($validatedData);

        return redirect()->route('index')->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanSK $Surat)
    {
        // Pass the LaporanSK instance to the view
        return Inertia::render('Surat/Read', [
            'Surat' => $Surat
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanSK $Surat)
    {
        return Inertia::render('Surat/Update', [
            'laporan' => $Surat, // This contains the existing data
            'Jurusan' => Jurusan::all(), // Fetch all jurusan data
            'Kategories' => Kategori::all(), // Fetch all kategori data
            'SubKategories' => SubKategori::all(), // Fetch all sub kategori data
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

        return redirect()->route('index')->with('success', 'Laporan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanSK $Surat)
    {
        $Surat->delete();

        return redirect()->route('surat.index')->with('success', 'Item deleted successfully.');
    }
}
