<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function authenticating(Request $request)
    {
        // Validasi input dari form
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Coba untuk mengotentikasi pengguna
        if (Auth::attempt($credentials)) {
            // Jika otentikasi berhasil, perbarui sesi pengguna

            // cek apakah user status = active
            if(Auth::user()->status != 'active'){
                Session::flash('status', 'failed');
                Session::flash('message', 'Your account is not active yet. Please contact admin!');
                return redirect('login');
            }
            $request->session()->regenerate();
            dd(Auth::user()->role_id == 1);
           return redirect()->intended('dashboard');
           dd(Auth::user()->role_id == 3);
           return redirect()->intended('profile');
           dd(Auth::user()->role_id == 4);
           return redirect()->intended('dashboard');


        // Redirect pengguna ke halaman dashboard jika status aktif
           
           
        }

        // Jika otentikasi gagal, kembalikan ke halaman login dengan pesan kesalahan
        Session::flash('status', 'failed');
        Session::flash('message', 'Login Invalid');
        return redirect('login');
    }
}
