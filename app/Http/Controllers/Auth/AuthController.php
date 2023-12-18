<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginIndex()
    {
        $title = 'Login';
        return view('auth.login', compact('title'));
    }

    public function forgotPassword()
    {
        $title = 'Forgot Password';
        return view('auth.forgot_password', compact('title'));
    }
}
