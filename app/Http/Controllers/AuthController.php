<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Authentication - Login Sistem'
        ];

        return view('auth/login', $data);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->put('user_role', Auth::user()->role);

            return redirect()->intended('home')->with('status', 'success')->with('message', 'Login successful');
        } else {
            return redirect()->route('login')->with('status', 'error')->with('message', 'Invalid credentials');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('login')->with('status', 'success')->with('message', 'Logout successful');
    }
}
