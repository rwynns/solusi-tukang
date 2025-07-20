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
use App\Models\EarningSplit;
use App\Models\WithdrawalRequest;

class TukangDashboardController extends Controller
{
    public function index()
    {
        // Get the currently logged in user (tukang)
        $user = User::findOrFail(Auth::id());

        // Load the tukang profile with its relationships
        $user->load(['tukangProfile.location', 'tukangProfile.skills']);

        // Get tukang profile id
        $tukangProfileId = $user->tukangProfile ? $user->tukangProfile->id : null;

        if (!$tukangProfileId) {
            return view('tukang.index', compact('user'));
        }

        // Get order IDs where this tukang is assigned
        $orderIds = DB::table('order_items')
            ->where('tukang_profile_id', $tukangProfileId)
            ->select('order_id')
            ->distinct()
            ->get()
            ->pluck('order_id')
            ->toArray();

        // Calculate statistics
        $stats = [
            'total_orders' => count($orderIds),
            'active_orders' => DB::table('orders')
                ->whereIn('id', $orderIds)
                ->where('status', 'processing')
                ->count(),
            'completed_orders' => DB::table('orders')
                ->whereIn('id', $orderIds)
                ->where('status', 'completed')
                ->count(),
            // Earning Statistics - merge here for template consistency
            'total_earnings' => EarningSplit::where('tukang_id', $user->id)->sum('tukang_amount'),
            'monthly_earnings' => EarningSplit::where('tukang_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('tukang_amount'),
            'available_balance' => $user->available_balance ?? 0,
            'pending_withdrawals' => $user->pending_withdrawals ?? 0,
            'withdrawable_balance' => $user->withdrawable_balance ?? 0,
        ];

        // Earning Statistics (keep separate for backward compatibility)
        $earningStats = [
            'total_earnings' => $stats['total_earnings'],
            'monthly_earnings' => $stats['monthly_earnings'],
            'available_balance' => $stats['available_balance'],
            'pending_withdrawals' => $stats['pending_withdrawals'],
            'withdrawable_balance' => $stats['withdrawable_balance'],
        ];

        // Get recent orders
        $recent_orders = \App\Models\Order::whereIn('id', $orderIds)
            ->with('orderItems')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get earning splits for this tukang
        $earning_splits = EarningSplit::where('tukang_id', $user->id)
            ->with(['order'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get recent withdrawals
        $recent_withdrawals = WithdrawalRequest::where('tukang_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('tukang.index', compact(
            'user',
            'stats',
            'earningStats',
            'recent_orders',
            'earning_splits',
            'recent_withdrawals'
        ));
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
