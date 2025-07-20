<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Models\EarningSplit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EarningsController extends Controller
{
    public function index(Request $request)
    {
        $tukang = Auth::user();

        // Get query filters
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $month = $request->get('month');
        $year = $request->get('year', date('Y'));

        // Base query for this tukang's earnings
        $query = EarningSplit::where('tukang_id', $tukang->id)
            ->with(['order', 'order.orderItems.subJasa.jasa']);

        // Apply filters
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($month) {
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        }

        // Get paginated results
        $earnings = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate statistics
        $totalEarnings = EarningSplit::where('tukang_id', $tukang->id)->sum('tukang_amount');

        $monthlyEarnings = EarningSplit::where('tukang_id', $tukang->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('tukang_amount');

        $todayEarnings = EarningSplit::where('tukang_id', $tukang->id)
            ->whereDate('created_at', today())
            ->sum('tukang_amount');

        // All earnings are automatically distributed when payment is completed
        $distributedEarnings = $totalEarnings;
        $pendingEarnings = 0;

        // Monthly earnings for chart (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $amount = EarningSplit::where('tukang_id', $tukang->id)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('tukang_amount');

            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'amount' => $amount
            ];
        }

        return view('tukang.earnings.index', compact(
            'earnings',
            'totalEarnings',
            'monthlyEarnings',
            'todayEarnings',
            'distributedEarnings',
            'pendingEarnings',
            'monthlyData'
        ));
    }

    public function show($id)
    {
        $tukang = Auth::user();

        $earning = EarningSplit::where('tukang_id', $tukang->id)
            ->with(['order', 'order.orderItems.subJasa.jasa'])
            ->findOrFail($id);

        return view('tukang.earnings.show', compact('earning'));
    }
}
