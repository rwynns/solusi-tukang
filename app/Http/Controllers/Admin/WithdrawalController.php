<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Models\PlatformBalance;
use App\Models\BalanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = WithdrawalRequest::with(['user', 'bankAccount'])
            ->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $withdrawals = $query->paginate(20);

        $stats = [
            'total_pending' => WithdrawalRequest::where('status', 'pending')->count(),
            'total_approved' => WithdrawalRequest::where('status', 'approved')->count(),
            'total_completed' => WithdrawalRequest::where('status', 'completed')->count(),
            'total_rejected' => WithdrawalRequest::where('status', 'rejected')->count(),
            'pending_amount' => WithdrawalRequest::where('status', 'pending')->sum('requested_amount'),
            'monthly_completed' => WithdrawalRequest::where('status', 'completed')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->sum('requested_amount')
        ];

        return view('admin.withdrawals.index', compact('withdrawals', 'stats', 'status'));
    }

    public function show(WithdrawalRequest $withdrawal)
    {
        $withdrawal->load(['user.tukangProfile', 'bankAccount', 'balanceTransaction']);

        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    public function approve(WithdrawalRequest $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->withErrors(['error' => 'Withdrawal sudah diproses sebelumnya.']);
        }

        try {
            DB::beginTransaction();

            // Update status ke approved
            $withdrawal->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id()
            ]);

            // Process withdrawal in platform balance
            $platformBalance = PlatformBalance::first();
            if ($platformBalance) {
                $platformBalance->processWithdrawal($withdrawal->id, $withdrawal->net_amount);
            }

            DB::commit();

            return back()->with('success', 'Withdrawal berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menyetujui withdrawal: ' . $e->getMessage()]);
        }
    }

    public function reject(Request $request, WithdrawalRequest $withdrawal)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500'
        ]);

        if ($withdrawal->status !== 'pending') {
            return back()->withErrors(['error' => 'Withdrawal sudah diproses sebelumnya.']);
        }

        try {
            DB::beginTransaction();

            // Update status ke rejected
            $withdrawal->update([
                'status' => 'rejected',
                'admin_notes' => $request->admin_notes
            ]);

            DB::commit();

            return back()->with('success', 'Withdrawal berhasil ditolak.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menolak withdrawal: ' . $e->getMessage()]);
        }
    }

    public function markCompleted(WithdrawalRequest $withdrawal)
    {
        if ($withdrawal->status !== 'approved') {
            return back()->withErrors(['error' => 'Withdrawal belum disetujui.']);
        }

        try {
            DB::beginTransaction();

            // Update status ke completed
            $withdrawal->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);

            // Complete withdrawal in platform balance
            $platformBalance = PlatformBalance::first();
            if ($platformBalance) {
                $platformBalance->completeWithdrawal($withdrawal->id, $withdrawal->net_amount);
            }

            // Log withdrawal completion
            BalanceTransaction::create([
                'tukang_id' => $withdrawal->tukang_id,
                'withdrawal_request_id' => $withdrawal->id,
                'type' => 'withdrawal_completed',
                'amount' => $withdrawal->requested_amount,
                'description' => "Withdrawal selesai ditransfer - {$withdrawal->bankAccount->bank_name} ({$withdrawal->bankAccount->account_number})"
            ]);

            DB::commit();

            return back()->with('success', 'Withdrawal berhasil diselesaikan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menyelesaikan withdrawal: ' . $e->getMessage()]);
        }
    }

    public function batchProcess(Request $request)
    {
        // Debug logging
        \Illuminate\Support\Facades\Log::info('Batch process started', [
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'withdrawal_ids' => 'required|array',
            'withdrawal_ids.*' => 'exists:withdrawal_requests,id',
            'action' => 'required|in:approve,reject,complete'
        ]);

        $withdrawals = WithdrawalRequest::with('bankAccount')->whereIn('id', $request->withdrawal_ids)->get();

        $processed = 0;
        $errors = [];

        foreach ($withdrawals as $withdrawal) {
            try {
                DB::beginTransaction();

                switch ($request->action) {
                    case 'approve':
                        if ($withdrawal->status === 'pending') {
                            $withdrawal->update([
                                'status' => 'approved',
                                'approved_at' => now(),
                                'approved_by' => Auth::id()
                            ]);

                            // Process withdrawal in platform balance
                            $platformBalance = PlatformBalance::first();
                            if ($platformBalance) {
                                $platformBalance->processWithdrawal($withdrawal->id, $withdrawal->net_amount);
                            }

                            $processed++;
                            \Illuminate\Support\Facades\Log::info("Withdrawal {$withdrawal->id} approved");
                        }
                        break;

                    case 'complete':
                        if ($withdrawal->status === 'approved') {
                            $withdrawal->update([
                                'status' => 'completed',
                                'completed_at' => now()
                            ]);

                            // Complete withdrawal in platform balance
                            $platformBalance = PlatformBalance::first();
                            if ($platformBalance) {
                                $platformBalance->completeWithdrawal($withdrawal->id, $withdrawal->net_amount);
                            }

                            // Log completion
                            BalanceTransaction::create([
                                'tukang_id' => $withdrawal->tukang_id,
                                'withdrawal_request_id' => $withdrawal->id,
                                'type' => 'withdrawal_completed',
                                'amount' => $withdrawal->requested_amount,
                                'description' => "Withdrawal selesai (batch) - {$withdrawal->bankAccount->bank_name}"
                            ]);

                            $processed++;
                            \Illuminate\Support\Facades\Log::info("Withdrawal {$withdrawal->id} completed");
                        }
                        break;

                    case 'reject':
                        if ($withdrawal->status === 'pending') {
                            $withdrawal->update([
                                'status' => 'rejected',
                                'admin_notes' => 'Ditolak melalui batch process'
                            ]);
                            $processed++;
                            \Illuminate\Support\Facades\Log::info("Withdrawal {$withdrawal->id} rejected");
                        }
                        break;
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                $errors[] = "Withdrawal ID {$withdrawal->id}: " . $e->getMessage();
                \Illuminate\Support\Facades\Log::error("Batch process error for withdrawal {$withdrawal->id}", [
                    'error' => $e->getMessage()
                ]);
            }
        }

        $message = "$processed withdrawal berhasil diproses.";
        if (!empty($errors)) {
            $message .= " Error: " . implode(', ', $errors);
        }

        \Illuminate\Support\Facades\Log::info('Batch process completed', [
            'processed' => $processed,
            'errors' => $errors
        ]);

        return back()->with('success', $message);
    }
}
