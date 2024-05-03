<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{

    public function loginIndex()
    {
        $title = 'Login';
        $tahun = date('Y');
        // get cookie email dan password jika ada
        $email = Cookie::get('email');
        $password = Cookie::get('password');
        $remember = Cookie::get('remember_me');
        if($remember == '1'){
            $remember = true;
        }
        return view('auth.login', compact('title', 'tahun', 'email', 'password','remember'));
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember_me') ? true : false;
        if (Auth::attempt($credentials)) {
            $email = $request->email;
            $password = $request->password;
            if ($remember) {
                Cookie::queue('email', $email, 60 * 24 * 30);
                Cookie::queue('password', $password, 60 * 24 * 30);
                Cookie::queue('remember_me', $remember, 60 * 24 * 30);
            } else {
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('password'));
            }
            return redirect()->intended('admin/dashboard');
        }
        return back()->with('error', 'Email atau password salah');
    }

    public function forgotPassword()
    {
        $title = 'Forgot Password';
        return view('auth.forgot_password', compact('title'));
    }
    
    public function logout(){
        Auth::logout();
        return redirect('auth/login');
    }
}
