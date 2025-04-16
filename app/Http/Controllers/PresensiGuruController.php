<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class PresensiGuruController extends Controller
{
    
    public function scanQrGuru(Request $request)
    {
        $query = Presensi::with('user')->latest();
    
        // if ($request->filled('start_date') && $request->filled('end_date')) {
        //     $startDate = Carbon::parse($request->start_date)->startOfDay();
        //     $endDate = Carbon::parse($request->end_date)->endOfDay();
    
        //     $query->whereBetween('created_at', [$startDate, $endDate]);
        // } else {
            $today = Carbon::now()->toDateString();
            $query->whereDate('created_at', $today);
        // }
    
        $presensis = $query->get();
    
        return view('scanQrGuru', compact('presensis'));
    }
    

    public function presensiGuru(Request $request)
    {
        $user = auth()->user();
    
        $sudahPresensi = Presensi::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->exists();
    
        if ($sudahPresensi) {
            return redirect()->back()->with('warning', $user->name . ', Anda sudah presensi hari ini!');
        }
    
        Presensi::create([
            'user_id' => $user->id,
            'qr_code' => $request->qr_code,
            'created_at' => now(),
        ]);
    
        return redirect()->back()->with('success', 'Presensi berhasil! ' . 'Nama Siswa : ' . $user->name);
    }
    
    

    public function PresensiListGuru(Request $request)
    {
        $query = Presensi::with('user')->latest();
    
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }
    
        $presensis = $query->get();
    
        return view('presensiList', compact('presensis'));
    }

    
}
