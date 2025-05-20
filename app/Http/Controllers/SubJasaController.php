<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\SubJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubJasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SubJasa::query();

        // Filter by jasa_id if provided
        if ($request->has('jasa_id')) {
            $query->where('jasa_id', $request->jasa_id);
            $jasa = Jasa::findOrFail($request->jasa_id);
            $title = "Sub Jasa untuk: {$jasa->nama}";
        } else {
            $title = "Semua Sub Jasa";
            $query->with('jasa'); // Eager load jasa relationship
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('deskripsi', 'LIKE', "%{$search}%");
        }

        $subJasaList = $query->latest()->paginate(10);

        return view('admin.sub-jasa.index', compact('subJasaList', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $jasaList = Jasa::orderBy('nama')->get();
        $selectedJasa = null;

        // Pre-select jasa if jasa_id provided
        if ($request->has('jasa_id')) {
            $selectedJasa = Jasa::findOrFail($request->jasa_id);
        }

        return view('admin.sub-jasa.create', compact('jasaList', 'selectedJasa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jasa_id' => 'required|exists:jasa,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ], [
            'jasa_id.required' => 'Jasa utama wajib dipilih',
            'jasa_id.exists' => 'Jasa utama tidak valid',
            'nama.required' => 'Nama sub jasa wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimum adalah 0',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'gambar.max' => 'Ukuran gambar maksimal 3MB',
        ]);

        $data = $request->only(['jasa_id', 'nama', 'deskripsi', 'harga']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('sub-jasa', 'public');
        }

        SubJasa::create($data);

        return redirect()->route('sub-jasa.index', ['jasa_id' => $request->jasa_id])
            ->with('success', 'Sub jasa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubJasa $subJasa)
    {
        $subJasa->load('jasa'); // Eager load jasa relationship
        return view('sub-jasa.show', compact('subJasa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubJasa $subJasa)
    {
        $jasaList = Jasa::orderBy('nama')->get();
        return view('sub-jasa.edit', compact('subJasa', 'jasaList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubJasa $subJasa)
    {
        $request->validate([
            'jasa_id' => 'required|exists:jasa,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'jasa_id.required' => 'Jasa utama wajib dipilih',
            'jasa_id.exists' => 'Jasa utama tidak valid',
            'nama.required' => 'Nama sub jasa wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimum adalah 0',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'gambar.max' => 'Ukuran gambar maksimal 3MB',
        ]);

        $data = $request->only(['jasa_id', 'nama', 'deskripsi', 'harga']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($subJasa->gambar && Storage::disk('public')->exists($subJasa->gambar)) {
                Storage::disk('public')->delete($subJasa->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('sub-jasa', 'public');
        }

        $subJasa->update($data);

        return redirect()->route('sub-jasa.index', ['jasa_id' => $subJasa->jasa_id])
            ->with('success', 'Sub jasa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubJasa $subJasa)
    {
        $jasaId = $subJasa->jasa_id; // Save before deleting

        // Delete image if exists
        if ($subJasa->gambar && Storage::disk('public')->exists($subJasa->gambar)) {
            Storage::disk('public')->delete($subJasa->gambar);
        }

        $subJasa->delete();

        return redirect()->route('sub-jasa.index', ['jasa_id' => $jasaId])
            ->with('success', 'Sub jasa berhasil dihapus');
    }
}
