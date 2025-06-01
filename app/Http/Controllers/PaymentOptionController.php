<?php

namespace App\Http\Controllers;

use App\Models\PaymentOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentOptionController extends Controller
{

    public function index()
    {
        $paymentOptions = PaymentOption::orderBy('name')->get();
        return view('admin.payment-options.index', compact('paymentOptions'));
    }

    public function create()
    {
        return view('admin.payment-options.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle file uploads
        if ($request->hasFile('qr_code')) {
            $validated['qr_code'] = $request->file('qr_code')->store('payment_qr_codes', 'public');
        }

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('payment_logos', 'public');
        }

        PaymentOption::create($validated);

        return redirect()->route('payment-options.index')
            ->with('success', 'Payment option created successfully');
    }

    public function edit($id)
    {
        $paymentOption = PaymentOption::findOrFail($id);
        return view('admin.payment-options.edit', compact('paymentOption'));
    }

    public function update(Request $request, $id)
    {
        $paymentOption = PaymentOption::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Add this line to handle the checkbox properly
        $validated['is_active'] = $request->has('is_active');

        // Handle file uploads
        if ($request->hasFile('qr_code')) {
            // Delete old file if exists
            if ($paymentOption->qr_code) {
                Storage::disk('public')->delete($paymentOption->qr_code);
            }
            $validated['qr_code'] = $request->file('qr_code')->store('payment_qr_codes', 'public');
        }

        if ($request->hasFile('logo')) {
            // Delete old file if exists
            if ($paymentOption->logo) {
                Storage::disk('public')->delete($paymentOption->logo);
            }
            $validated['logo'] = $request->file('logo')->store('payment_logos', 'public');
        }

        $paymentOption->update($validated);

        return redirect()->route('payment-options.index')
            ->with('success', 'Payment option updated successfully');
    }

    public function destroy($id)
    {
        $paymentOption = PaymentOption::findOrFail($id);

        // Delete associated files
        if ($paymentOption->qr_code) {
            Storage::disk('public')->delete($paymentOption->qr_code);
        }
        if ($paymentOption->logo) {
            Storage::disk('public')->delete($paymentOption->logo);
        }

        $paymentOption->delete();

        return redirect()->route('payment-options.index')
            ->with('success', 'Payment option deleted successfully');
    }

    public function toggleStatus($id)
    {
        $paymentOption = PaymentOption::findOrFail($id);
        $paymentOption->is_active = !$paymentOption->is_active;
        $paymentOption->save();

        return response()->json([
            'success' => true,
            'is_active' => $paymentOption->is_active
        ]);
    }
}
