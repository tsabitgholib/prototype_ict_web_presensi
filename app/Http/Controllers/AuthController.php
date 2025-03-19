<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|string|exists:users,nis',
            'captcha' => 'required|captcha'
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $user = User::where('nis', $request->nis)->first();
    
        if ($user) {
            Auth::login($user);
            return redirect()->route('scan.qr');
        }
    
        return back()->withErrors(['error' => 'NIS tidak ditemukan']);
    }
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
