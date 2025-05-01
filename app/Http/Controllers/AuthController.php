<?php

namespace App\Http\Controllers;

use App\Models\Guru;
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

        Auth::logout();
        Auth::guard('guru')->logout();

        $validator = Validator::make($request->all(), [
            'tipe_login' => 'required|in:siswa,guru',
            'identifier' => 'required|string',
            'captcha' => 'required|captcha',
        ], [
            'identifier.required' => 'NIS/NIP wajib diisi.',
            'captcha.captcha' => 'Captcha tidak valid.',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        if ($request->tipe_login === 'siswa') {
            $user = User::where('nis', $request->identifier)->first();
            if (!$user) {
                return back()->withErrors(['identifier' => 'NIS tidak ditemukan.'])->withInput();
            }
    
            Auth::login($user);
            return redirect()->route('scan.qr.siswa');
    
        } else if ($request->tipe_login === 'guru') {
            $guru = Guru::where('nip', $request->identifier)->first();
            if (!$guru) {
                return back()->withErrors(['identifier' => 'NIK tidak ditemukan.'])->withInput();
            }
    
            Auth::guard('guru')->loginUsingId($guru->id);
            return redirect()->route('scan.qr.guru');
        }
    
        return back()->withErrors(['tipe_login' => 'Tipe login tidak valid.'])->withInput();
    }
    
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
