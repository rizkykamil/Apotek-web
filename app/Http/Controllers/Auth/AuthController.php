<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember_me') ? true : false;
        
        if (Auth::attempt($credentials, $remember)) {
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
