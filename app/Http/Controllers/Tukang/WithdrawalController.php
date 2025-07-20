<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Models\TukangBankAccount;
use App\Models\BalanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WithdrawalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $withdrawals = WithdrawalRequest::where('tukang_id', $user->id)
            ->with('bankAccount')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'available_balance' => $user->available_balance,
            'pending_withdrawals' => $user->pending_withdrawals,
            'withdrawable_balance' => $user->withdrawable_balance,
            'total_withdrawn' => WithdrawalRequest::where('tukang_id', $user->id)
                ->where('status', 'completed')
                ->sum('requested_amount')
        ];

        return view('tukang.withdrawals.index', compact('withdrawals', 'stats'));
    }

    public function create()
    {
        $user = Auth::user();
        $bankAccounts = TukangBankAccount::where('tukang_id', $user->id)
            ->get();

        if ($bankAccounts->isEmpty()) {
            return redirect()->route('tukang.bank-accounts.create')
                ->with('error', 'Anda harus menambahkan rekening bank terlebih dahulu.');
        }

        $minWithdrawal = WithdrawalRequest::getMinimumAmount();
        $adminFee = WithdrawalRequest::getAdminFee();

        return view('tukang.withdrawals.create', compact('bankAccounts', 'minWithdrawal', 'adminFee'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'bank_account_id' => 'required|exists:tukang_bank_accounts,id',
            'amount' => 'required|numeric|min:' . WithdrawalRequest::getMinimumAmount()
        ]);

        $bankAccount = TukangBankAccount::where('id', $request->bank_account_id)
            ->where('tukang_id', $user->id)
            ->first();

        if (!$bankAccount) {
            return back()->withErrors(['bank_account_id' => 'Rekening bank tidak valid.']);
        }

        // Cek saldo
        if ($request->amount > $user->withdrawable_balance) {
            return back()->withErrors(['amount' => 'Saldo tidak mencukupi.']);
        }

        try {
            DB::beginTransaction();

            $adminFee = WithdrawalRequest::getAdminFee();
            $totalAmount = $request->amount + $adminFee;

            // Buat withdrawal request
            $withdrawal = WithdrawalRequest::create([
                'withdrawal_number' => WithdrawalRequest::generateWithdrawalNumber(),
                'tukang_id' => $user->id,
                'bank_account_id' => $bankAccount->id,
                'requested_amount' => $request->amount,
                'fee_amount' => $adminFee,
                'net_amount' => $totalAmount,
                'status' => 'pending'
            ]);

            // Log aktivitas
            BalanceTransaction::create([
                'tukang_id' => $user->id,
                'withdrawal_request_id' => $withdrawal->id,
                'type' => 'withdrawal_request',
                'amount' => $request->amount,
                'description' => "Pengajuan withdrawal ke {$bankAccount->bank_name} - {$bankAccount->account_number}"
            ]);

            DB::commit();

            return redirect()->route('tukang.withdrawals.index')
                ->with('success', 'Pengajuan withdrawal berhasil dikirim.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal mengajukan withdrawal: ' . $e->getMessage()]);
        }
    }

    public function show(WithdrawalRequest $withdrawal)
    {
        // Pastikan withdrawal milik user yang login
        if ($withdrawal->tukang_id !== Auth::id()) {
            abort(404);
        }

        $withdrawal->load(['bankAccount', 'balanceTransaction']);

        return view('tukang.withdrawals.show', compact('withdrawal'));
    }

    public function cancel(WithdrawalRequest $withdrawal)
    {
        // Pastikan withdrawal milik user yang login
        if ($withdrawal->tukang_id !== Auth::id()) {
            abort(404);
        }

        if ($withdrawal->status !== 'pending') {
            return back()->withErrors(['error' => 'Withdrawal sudah diproses dan tidak bisa dibatalkan.']);
        }

        try {
            DB::beginTransaction();

            $withdrawal->update([
                'status' => 'cancelled',
                'cancelled_at' => now()
            ]);

            // Log aktivitas
            BalanceTransaction::create([
                'tukang_id' => Auth::id(),
                'withdrawal_request_id' => $withdrawal->id,
                'type' => 'withdrawal_cancelled',
                'amount' => $withdrawal->requested_amount,
                'description' => 'Withdrawal dibatalkan oleh tukang'
            ]);

            DB::commit();

            return back()->with('success', 'Withdrawal berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal membatalkan withdrawal: ' . $e->getMessage()]);
        }
    }
}
