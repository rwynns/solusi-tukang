<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Skill::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Change from latest() to oldest() to show earliest created skills first
        $query->oldest();

        // Paginate the results
        $skills = $query->paginate(10);

        return view('admin.skill.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.skill.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name',
        ], [
            'name.required' => 'Nama keahlian wajib diisi',
            'name.unique' => 'Nama keahlian sudah ada',
        ]);

        Skill::create([
            'name' => $request->name,
        ]);

        return redirect()->route('skills.index')
            ->with('success', 'Keahlian berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        return redirect()->route('skills.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return view('admin.skill.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name,' . $skill->id,
        ], [
            'name.required' => 'Nama keahlian wajib diisi',
            'name.unique' => 'Nama keahlian sudah ada',
        ]);

        $skill->update([
            'name' => $request->name,
        ]);

        return redirect()->route('skills.index')
            ->with('success', 'Keahlian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('skills.index')
            ->with('success', 'Keahlian berhasil dihapus!');
    }
}
