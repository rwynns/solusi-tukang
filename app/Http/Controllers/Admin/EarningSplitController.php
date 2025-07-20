<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EarningSplit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EarningSplitController extends Controller
{
    /**
     * Display a listing of the earning splits.
     */
    public function index(Request $request): View
    {
        $query = EarningSplit::with(['order', 'tukang']);

        // Filter by tukang
        if ($request->filled('tukang_id')) {
            $query->where('tukang_id', $request->tukang_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $splits = $query->latest()->paginate(15)->withQueryString();

        // Get tukang list for filter
        $tukangs = User::whereHas('tukangProfile')->get();

        // Calculate totals
        $totalAdminEarnings = EarningSplit::getTotalAdminEarnings();
        $totalTukangEarnings = EarningSplit::getTotalTukangEarnings();
        $monthlyAdminEarnings = EarningSplit::getTotalAdminEarnings('month');
        $monthlyTukangEarnings = EarningSplit::getTotalTukangEarnings(null, 'month');

        return view('admin.earning-splits.index', compact(
            'splits',
            'tukangs',
            'totalAdminEarnings',
            'totalTukangEarnings',
            'monthlyAdminEarnings',
            'monthlyTukangEarnings'
        ));
    }
}
