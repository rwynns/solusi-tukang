<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Skill;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TukangDashboardController extends Controller
{
    public function index()
    {
        // Get the currently logged in user (tukang)
        $user = User::findOrFail(Auth::id());

        // Load the tukang profile with its relationships
        $user->load(['tukangProfile.location', 'tukangProfile.skills']);

        return view('dashboard.index-tukang', compact('user'));
    }

    public function editProfile()
    {
        $user = User::findOrFail(Auth::id());
        $user->load(['tukangProfile.skills']);

        $locations = Location::orderBy('name')->get();
        $skills = Skill::orderBy('name')->get();

        // Get the selected skills IDs
        $selectedSkills = $user->tukangProfile ?
            $user->tukangProfile->skills->pluck('id')->toArray() :
            [];

        return view('tukang.edit', compact('user', 'locations', 'skills', 'selectedSkills'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:skills,id',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Update user data
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ];

            $user->update($userData);

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old photo if exists
                if ($user->tukangProfile && $user->tukangProfile->profile_photo) {
                    Storage::disk('public')->delete($user->tukangProfile->profile_photo);
                }

                $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');

                // Update profile photo path
                $user->tukangProfile->update([
                    'profile_photo' => $profilePhotoPath
                ]);
            }

            // Update tukang profile
            $user->tukangProfile->update([
                'location_id' => $request->location_id,
                'bio' => $request->bio,
            ]);

            // Sync skills
            $user->tukangProfile->skills()->sync($request->skills);

            DB::commit();

            return redirect()->route('profile')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showProfile()
    {
        // Get the currently logged in user (tukang)
        $user = User::findOrFail(Auth::id());

        // Load the tukang profile with its relationships
        $user->load(['tukangProfile.location', 'tukangProfile.skills']);

        return view('tukang.show', compact('user'));
    }
}
