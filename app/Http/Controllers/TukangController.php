<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Skill;
use App\Models\Jasa;
use App\Models\SubJasa;
use App\Models\Location;
use App\Models\TukangProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TukangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Dapatkan ID role tukang
        $tukangRole = Role::where('name', 'tukang')->first();

        // Query dasar untuk user dengan role tukang
        $query = User::where('role_id', $tukangRole->id)
            ->with(['tukangProfile.location', 'tukangProfile.skills']);

        // Filter berdasarkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan lokasi
        if ($request->has('location') && !empty($request->location)) {
            $query->whereHas('tukangProfile', function ($q) use ($request) {
                $q->where('location_id', $request->location);
            });
        }

        // Filter berdasarkan keahlian
        if ($request->has('skill') && !empty($request->skill)) {
            $query->whereHas('tukangProfile.skills', function ($q) use ($request) {
                $q->where('skills.id', $request->skill);
            });
        }

        // Urutkan data
        $query->latest();

        // Pagination
        $tukangs = $query->paginate(10);

        // Data untuk filter dropdown
        $locations = Location::orderBy('name')->get();
        $skills = SubJasa::select('id', 'nama as name')
            ->orderBy('nama')
            ->get();

        return view('admin.tukang.index', compact('tukangs', 'locations', 'skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::orderBy('name')->get();

        // Load SubJasa records instead of Skills
        $skills = SubJasa::select('id', 'nama as name')
            ->orderBy('nama')
            ->get();

        return view('admin.tukang.create', compact('locations', 'skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:sub_jasa,id',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'phone_number.required' => 'Nomor telepon wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'location_id.required' => 'Lokasi wajib dipilih',
            'location_id.exists' => 'Lokasi tidak valid',
            'skills.required' => 'Minimal satu keahlian harus dipilih',
            'skills.min' => 'Minimal satu keahlian harus dipilih',
            'skills.*.exists' => 'Keahlian tidak valid',
            'profile_photo.image' => 'File harus berupa gambar',
            'profile_photo.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'profile_photo.max' => 'Ukuran gambar maksimal 3MB',
        ]);

        // Dapatkan role tukang
        $tukangRole = Role::where('name', 'tukang')->first();

        DB::beginTransaction();

        try {
            // Buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'role_id' => $tukangRole->id,
            ]);

            // Upload foto profil jika ada
            $profilePhotoPath = null;
            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
                Log::info('File uploaded to: ' . $profilePhotoPath);
            }

            // Buat profil tukang
            $tukangProfile = TukangProfile::create([
                'user_id' => $user->id,
                'location_id' => $request->location_id,
                'bio' => $request->bio,
                'profile_photo' => $profilePhotoPath,
            ]);

            // Tambahkan keahlian
            $tukangProfile->skills()->attach($request->skills);

            DB::commit();

            return redirect()->route('tukang.index')
                ->with('success', 'Tukang berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();

            // Hapus file yang diupload jika ada error
            if (isset($profilePhotoPath) && Storage::disk('public')->exists($profilePhotoPath)) {
                Storage::disk('public')->delete($profilePhotoPath);
            }

            return redirect()->route('admin.tukang.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $tukang)
    {
        // Pastikan user adalah tukang
        if (!$tukang->isTukang()) {
            abort(404);
        }

        $tukang->load(['tukangProfile.location', 'tukangProfile.skills']);

        return view('admin.tukang.show', compact('tukang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $tukang)
    {
        // Pastikan user adalah tukang
        if (!$tukang->isTukang()) {
            abort(404);
        }

        $tukang->load(['tukangProfile.skills']);

        $locations = Location::orderBy('name')->get();

        // Load SubJasa records instead of Skills
        $skills = \App\Models\SubJasa::select('id', 'nama as name')
            ->orderBy('nama')
            ->get();

        // Dapatkan ID skill yang dimiliki tukang
        $selectedSkills = $tukang->tukangProfile->skills->pluck('id')->toArray();

        return view('admin.tukang.edit', compact('tukang', 'locations', 'skills', 'selectedSkills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $tukang)
    {
        // Pastikan user adalah tukang
        if (!$tukang->isTukang()) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($tukang->id)],
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:sub_jasa,id',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'phone_number.required' => 'Nomor telepon wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'location_id.required' => 'Lokasi wajib dipilih',
            'location_id.exists' => 'Lokasi tidak valid',
            'skills.required' => 'Minimal satu keahlian harus dipilih',
            'skills.min' => 'Minimal satu keahlian harus dipilih',
            'skills.*.exists' => 'Keahlian tidak valid',
            'profile_photo.image' => 'File harus berupa gambar',
            'profile_photo.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'profile_photo.max' => 'Ukuran gambar maksimal 2MB',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        DB::beginTransaction();

        try {
            // Update user
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ];

            // Update password jika diisi
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $tukang->update($userData);

            // Upload foto profil baru jika ada
            if ($request->hasFile('profile_photo')) {
                // Hapus foto lama jika ada
                if ($tukang->tukangProfile->profile_photo) {
                    Storage::disk('public')->delete($tukang->tukangProfile->profile_photo);
                }

                // Upload foto baru
                $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');

                // Update path foto
                $tukang->tukangProfile->update([
                    'profile_photo' => $profilePhotoPath
                ]);
            }

            // Update profil tukang
            $tukang->tukangProfile->update([
                'location_id' => $request->location_id,
                'bio' => $request->bio,
            ]);

            // Update keahlian
            $tukang->tukangProfile->skills()->sync($request->skills);

            DB::commit();

            return redirect()->route('tukang.index')
                ->with('success', 'Data tukang berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $tukang)
    {
        // Pastikan user adalah tukang
        if (!$tukang->isTukang()) {
            abort(404);
        }

        DB::beginTransaction();

        try {
            // Hapus foto profil jika ada
            if ($tukang->tukangProfile && $tukang->tukangProfile->profile_photo) {
                Storage::disk('public')->delete($tukang->tukangProfile->profile_photo);
            }

            // Hapus user (akan cascade delete tukang_profile berdasarkan constraint)
            $tukang->delete();

            DB::commit();

            return redirect()->route('admin.tukangs.index')
                ->with('success', 'Tukang berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
