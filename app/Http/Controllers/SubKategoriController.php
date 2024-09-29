<?php

namespace App\Http\Controllers;

use App\Models\SubKategori;
use App\Http\Requests\StoreSubKategoriRequest;
use App\Http\Requests\UpdateSubKategoriRequest;
use App\Models\Kategori;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SubKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subKategori = SubKategori::with('kategori')->get();
        return Inertia::render('subkategori.index', compact('subKategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return Inertia::render('subkategori.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubKategoriRequest $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
        ]);

        SubKategori::create($request->all());

        return redirect()->route(route: 'sk.create')->banner('sub kategori baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubKategori $subKategori)
    {
        return Inertia::render('subkategori.show', compact('subKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubKategori $subKategori)
    {
        $kategoris = Kategori::all();  // Correct capitalization and pluralization
        return Inertia::render('subkategori.edit', compact('subKategori', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubKategoriRequest $request, SubKategori $subKategori)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
        ]);

        $subKategori->update($request->all());

        return redirect()->route('subkategori.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubKategori $subKategori)
    {
        $subKategori->delete();

        return redirect()->route('subkategori.index')->with('success', 'Item deleted successfully.');
    }
}
