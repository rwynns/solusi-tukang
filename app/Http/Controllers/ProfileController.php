<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        User::where('id', $user->id)->update($validated);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Show the form for changing the user's password.
     */
    public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }

    /**
     * Change the user's password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    return $fail(__('Password saat ini salah.'));
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Display the tukang's profile.
     */
    public function tukangShow()
    {
        $user = Auth::user();
        return view('tukang.show', compact('user'));
    }

    /**
     * Show the form for editing the tukang's profile.
     */
    public function tukangEdit()
    {
        $user = Auth::user();
        $skills = \App\Models\SubJasa::all(); // Changed from Skill to SubJasa
        $locations = \App\Models\Location::all();
        $selectedSkills = $user->tukangProfile ? $user->tukangProfile->skills->pluck('id')->toArray() : [];

        return view('tukang.edit', compact('user', 'skills', 'locations', 'selectedSkills'));
    }

    /**
     * Update the tukang's profile information.
     */
    public function tukangUpdate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'location_id' => ['required', 'exists:locations,id'],
            'skills' => ['required', 'array'],
            'skills.*' => ['exists:sub_jasa,id'],
            'bio' => ['nullable', 'string'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Update user basic info
        User::where('id', $user->id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
        ]);

        // Update or create tukang profile
        $tukangProfile = $user->tukangProfile ?? new \App\Models\TukangProfile();
        $tukangProfile->user_id = $user->id;
        $tukangProfile->location_id = $validated['location_id'];
        $tukangProfile->bio = $validated['bio'] ?? null;

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $tukangProfile->profile_photo = $path;
        }

        $tukangProfile->save();

        // Sync skills
        $tukangProfile->skills()->sync($validated['skills']);

        return redirect()->route('tukang.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
