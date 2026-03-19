<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('frontend.home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('frontend.home');
        }

        $validated = $request->validate([
            'email_or_username' => ['required'],
            'password' => ['required'],
        ]);

        $loginField = filter_var($validated['email_or_username'], FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        if (Auth::attempt([$loginField => $validated['email_or_username'], 'password' => $validated['password']])) {
            $request->session()->regenerate();
            return redirect()->route('frontend.home');
        }

        return back()
            ->withErrors(['email_or_username' => 'Credenciales inválidas.'])
            ->withInput();
    }
}
