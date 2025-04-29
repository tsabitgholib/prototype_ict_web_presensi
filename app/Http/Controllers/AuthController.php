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
        if ($request->tipe_login == 'guru') {
            $guru = Guru::where('nip', $request->identifier)->first();

            if (!$guru) {
                return back()->withErrors(['identifier' => 'NIP tidak ditemukan.']);
            }

            Auth::guard('guru')->login($guru);

            return redirect()->route('scan.qr.guru');
        }

        $user = User::where('nis', $request->identifier)->first();

        if (!$user) {
            return back()->withErrors(['identifier' => 'NIS tidak ditemukan.']);
        }

        Auth::login($user);

        return redirect()->route('scan.qr.siswa');
    }




    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
