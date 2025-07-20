<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\EarningSplit;
use App\Models\PlatformBalance;
use App\Models\WithdrawalRequest;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Statistik Umum
        $stats = [
            'total_orders' => Order::count(),
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'paid_orders' => Order::where('payment_status', 'lunas')->count(),
            'pending_orders' => Order::where('payment_status', 'pending')->count(),
        ];

        // Statistik Earning Split
        $earningStats = [
            'total_revenue' => EarningSplit::sum('total_amount'),
            'admin_earnings' => EarningSplit::sum('admin_amount'),
            'tukang_earnings' => EarningSplit::sum('tukang_amount'),
            'today_revenue' => EarningSplit::whereDate('created_at', today())->sum('total_amount'),
            'monthly_revenue' => EarningSplit::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount'),
        ];

        // Platform Balance
        $platformBalance = PlatformBalance::getCurrentBalance();

        // Withdrawal Statistics
        $withdrawalStats = [
            'pending_withdrawals' => WithdrawalRequest::where('status', 'pending')->count(),
            'pending_amount' => WithdrawalRequest::where('status', 'pending')->sum('requested_amount'),
            'completed_today' => WithdrawalRequest::where('status', 'completed')
                ->whereDate('updated_at', today())->count(),
        ];

        // Recent Earning Splits
        $recentEarnings = EarningSplit::with(['order', 'tukang'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Recent Orders
        $recentOrders = Order::with(['user', 'payment'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.index', compact(
            'stats',
            'earningStats',
            'platformBalance',
            'withdrawalStats',
            'recentEarnings',
            'recentOrders'
        ));
    }
}
