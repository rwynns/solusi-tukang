<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Models\TukangBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = TukangBankAccount::where('tukang_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tukang.bank-accounts.index', compact('bankAccounts'));
    }

    public function create()
    {
        // Cek apakah tukang sudah memiliki bank account
        $existingAccount = TukangBankAccount::where('tukang_id', Auth::id())->first();

        if ($existingAccount) {
            return redirect()->route('tukang.bank-accounts.index')
                ->with('error', 'Anda sudah memiliki rekening bank. Untuk mengganti bank, hapus rekening yang ada terlebih dahulu.');
        }

        $bankList = TukangBankAccount::getBankList();

        return view('tukang.bank-accounts.create', compact('bankList'));
    }

    public function store(Request $request)
    {
        // Cek apakah tukang sudah memiliki bank account
        $existingAccount = TukangBankAccount::where('tukang_id', Auth::id())->first();

        if ($existingAccount) {
            return redirect()->route('tukang.bank-accounts.index')
                ->with('error', 'Anda sudah memiliki rekening bank. Untuk mengganti bank, hapus rekening yang ada terlebih dahulu.');
        }

        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:tukang_bank_accounts,account_number',
            'account_name' => 'required|string|max:255',
        ]);

        // Karena hanya 1 akun bank per tukang, selalu set sebagai primary dan verified
        TukangBankAccount::create([
            'tukang_id' => Auth::id(),
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder_name' => $request->account_name,
            'is_primary' => true,  // Selalu primary karena hanya 1 akun
            'is_verified' => true, // Langsung verified karena hanya 1 akun
        ]);

        return redirect()->route('tukang.bank-accounts.index')
            ->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    public function destroy(TukangBankAccount $bankAccount)
    {
        // Pastikan rekening milik user yang login
        if ($bankAccount->tukang_id !== Auth::id()) {
            abort(404);
        }

        // Cek apakah ada withdrawal yang masih pending
        $pendingWithdrawals = $bankAccount->withdrawalRequests()
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($pendingWithdrawals > 0) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus rekening yang masih memiliki withdrawal pending.']);
        }

        $bankAccount->delete();

        return back()->with('success', 'Rekening bank berhasil dihapus. Anda dapat menambahkan rekening bank baru.');
    }
}
