<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();
        return view('units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        $validated = $request->validated();
        $validated['name'] = Str::title($validated['name']);
        Unit::create($validated);
        return redirect()->route('units.index')->with('success', 'Satuan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $validated = $request->validated();
        $validated['name'] = Str::title($validated['name']);
        $unit->update($validated);
        return redirect()->route('units.index')->with('success', 'Satuan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Satuan berhasil dihapus!');
    }
}