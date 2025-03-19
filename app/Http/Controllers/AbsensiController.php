<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function scanQR()
    {
        return view('scan_qr');
    }

    public function absen(Request $request)
    {
        $user = auth()->user();
    
        $sudahAbsen = Absensi::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->exists();
    
        if ($sudahAbsen) {
            return redirect()->route('absensi.list')->with('warning', 'Anda sudah absen hari ini!');
        }
    
        Absensi::create([
            'user_id' => $user->id,
            'qr_code' => $request->qr_code,
            'created_at' => now(),
        ]);
    
        return redirect()->route('absensi.list')->with('success', 'Absensi berhasil!');
    }
    

    public function list()
    {
        $absensis = Absensi::with('user')->latest()->get();
        return view('absensi', compact('absensis'));
    }
}
