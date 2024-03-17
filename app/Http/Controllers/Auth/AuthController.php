<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginIndex()
    {
        $title = 'Login';
        $tahun = date('Y');
        return view('auth.login', compact('title', 'tahun'));
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

         
        $remember = $request->has('remember') ? true : false;

        if (auth()->attempt($request->only('email', 'password'), $remember)) {
            return redirect()->intended('admin/dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function forgotPassword()
    {
        $title = 'Forgot Password';
        return view('auth.forgot_password', compact('title'));
    }
}
