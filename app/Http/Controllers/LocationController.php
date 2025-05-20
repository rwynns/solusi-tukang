<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Location::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Order by name for a more logical listing
        $query->orderBy('name', 'asc');

        // Paginate the results
        $locations = $query->paginate(10);

        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
        ], [
            'name.required' => 'Nama lokasi wajib diisi',
            'name.unique' => 'Nama lokasi sudah ada',
        ]);

        Location::create([
            'name' => $request->name,
        ]);

        return redirect()->route('locations.index')
            ->with('success', 'Lokasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return redirect()->route('locations.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $location->id,
        ], [
            'name.required' => 'Nama lokasi wajib diisi',
            'name.unique' => 'Nama lokasi sudah ada',
        ]);

        $location->update([
            'name' => $request->name,
        ]);

        return redirect()->route('locations.index')
            ->with('success', 'Lokasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index')
            ->with('success', 'Lokasi berhasil dihapus!');
    }
}
