<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan form login
     * 
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('accounts.login');
    }

    /**
     * Handle permintaan login
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Kata sandi wajib diisi',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $welcomeMessage = 'Selamat datang kembali, ' . $user->name . '!';

            if ($user->role_id == 1) { // Admin
                return redirect()->intended('/admin/dashboard')->with('success', $welcomeMessage);
            } elseif ($user->role_id == 2) { // Tukang
                return redirect()->intended('/tukang/dashboard')->with('success', $welcomeMessage);
            } else { // Customer
                return redirect()->intended('/')->with('success', $welcomeMessage);
            }
        }

        throw ValidationException::withMessages([
            'email' => ['Kredensial yang diberikan tidak cocok dengan data kami.'],
        ]);
    }

    /**
     * Logout user
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
