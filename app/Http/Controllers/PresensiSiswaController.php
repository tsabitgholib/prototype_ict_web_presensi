<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiSiswaController extends Controller
{
    public function scanQrSiswa()
    {
        return view('scanQrSiswa');
    }

    public function presensiSiswa(Request $request)
    {
        $user = auth()->user();
    
        $sudahAbsen = Presensi::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->exists();
    
        if ($sudahAbsen) {
            return redirect()->back()->with('warning', $user->name . ', Anda sudah absen hari ini!');
        }
        
        Presensi::create([
            'user_id' => $user->id,
            'qr_code' => $request->qr_code,
            'created_at' => now(),
        ]);
    
        return redirect()->route('presensi.list.siswa')->with('success', 'Presensi berhasil!');
    }
    

    public function presensiListSiswa()
    {
        $presensis = Presensi::with('user')->latest()->get();
        return view('presensiList', compact('presensis'));
    }
}
