<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class Authcontroller extends Controller
{
    public function showLogin(){
        return view('content.login');
    }
    public function showLogout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function checkLogin(Request $request)
    {
        $credentials = $request->validate([
            //required เป็นค่าว่างไหม รูปแบบเป็น email
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/content');
        }
        return back()->withErrors([
            'email' => 'Creadentials do not match our records',
        ]);
    }
}
