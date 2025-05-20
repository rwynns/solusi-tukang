<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jasaList = Jasa::latest()->paginate(10);
        return view('admin.jasa.index', compact('jasaList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jasa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'slug' => 'nullable|string|unique:jasa,slug',
        ], [
            'nama.required' => 'Nama jasa wajib diisi',
            'deskripsi.required' => 'Deskripsi jasa wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'gambar.max' => 'Ukuran gambar maksimal 5MB',
            'slug.unique' => 'Slug sudah digunakan'
        ]);

        $data = $request->only(['nama', 'deskripsi']);

        // Handle slug
        if ($request->filled('slug')) {
            $data['slug'] = Str::slug($request->slug);
        } else {
            $data['slug'] = Str::slug($request->nama);
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('jasa', 'public');
        }

        Jasa::create($data);

        return redirect()->route('kelola-jasa.index')
            ->with('success', 'Jasa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jasa $jasa)
    {
        return view('admin.jasa.show', compact('jasa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jasa $jasa)
    {
        return view('admin.jasa.edit', compact('jasa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jasa $jasa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'slug' => 'nullable|string|unique:jasa,slug,' . $jasa->id,
        ], [
            'nama.required' => 'Nama jasa wajib diisi',
            'deskripsi.required' => 'Deskripsi jasa wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'gambar.max' => 'Ukuran gambar maksimal 5MB',
            'slug.unique' => 'Slug sudah digunakan'
        ]);

        $data = $request->only(['nama', 'deskripsi']);

        // Handle slug
        if ($request->filled('slug')) {
            $data['slug'] = Str::slug($request->slug);
        } else {
            $data['slug'] = Str::slug($request->nama);
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($jasa->gambar && Storage::disk('public')->exists($jasa->gambar)) {
                Storage::disk('public')->delete($jasa->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('jasa', 'public');
        }

        $jasa->update($data);

        return redirect()->route('kelola-jasa.index')
            ->with('success', 'Jasa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jasa $jasa)
    {
        // Delete image if exists
        if ($jasa->gambar && Storage::disk('public')->exists($jasa->gambar)) {
            Storage::disk('public')->delete($jasa->gambar);
        }

        $jasa->delete();

        return redirect()->route('kelola-jasa.index')
            ->with('success', 'Jasa berhasil dihapus');
    }

    /**
     * Show services on homepage
     */
    public function home()
    {
        $jasaList = Jasa::latest()->get();
        return view('admin.home.jasa', compact('jasaList'));
    }

    public function detail(Jasa $jasa)
    {
        // Eager load sub jasa
        $jasa->load('subJasa');

        return view('detail-jasa', compact('jasa'));
    }

    /**
     * API endpoint untuk mendapatkan detail sub jasa
     */
    public function getSubJasa($id)
    {
        $subJasa = \App\Models\SubJasa::findOrFail($id);
        return response()->json($subJasa);
    }
}
