<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Http\Requests\StoreSuratRequest;
use App\Http\Requests\UpdateSuratRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Surat/Index', [
            'surats' => Surat::with(['user', 'prodi']) // Eager load
            ->when($request->input('search'), function ($query, $search) {
                $query->whereHas('prodi', function($q) use ($search) {
                    $q->where('nama_prodi', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('judul', 'like', "%{$search}%")
                ->orWhere('tahun_ajaran', 'like', "%{$search}%");
            })        
                ->paginate(10)
                ->withQueryString()
                ->through(fn($surat) => [
                    'id' => $surat->id,
                    'prodi_id' => $surat->prodi_id,
                    'judul' => $surat->judul,
                    'user_id' => $surat->user_id,
                    'tahun_ajaran' => $surat->tahun_akademik,
                    'can' => [
                        'edit' => Auth::user()->can('edit', $surat),
                    ],
                ]),
            'filters' => $request->only(['search']),
            'can' => [
                'createUser' => Auth::user()->can('create', Surat::class),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuratRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuratRequest $request, Surat $surat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surat $surat)
    {
        //
    }
}
