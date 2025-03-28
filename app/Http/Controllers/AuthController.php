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
            'nis' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!User::where('nis', $value)->exists()) {
                        $fail('NIS tidak ditemukan.');
                    }
                }
            ],
            'captcha' => 'required|captcha'
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'captcha.captcha' => 'Captcha tidak valid.'
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $user = User::where('nis', $request->nis)->first();
    
        Auth::login($user);
        return redirect()->route('scan.qr.siswa');
    }
    
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
