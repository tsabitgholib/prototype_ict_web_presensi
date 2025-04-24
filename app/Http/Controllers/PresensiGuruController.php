<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class PresensiGuruController extends Controller
{
    // protected $latitudeSekolah = -6.9677;
    // protected $longitudeSekolah = 110.2458;
    protected $latitudeSekolah = -6.98749480;
    protected $longitudeSekolah = 110.43590270;
    protected $radiusMax = 100;
    
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

        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $latitudeUser = $request->latitude;
        $longitudeUser = $request->longitude;

        $jarak = $this->haversine($this->latitudeSekolah, $this->longitudeSekolah, $latitudeUser, $longitudeUser);
    
        $sudahPresensi = Presensi::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->exists();

        if ($jarak > $this->radiusMax) {
            return redirect()->back()->with('warning', 'Anda terlalu jauh dari lokasi presensi!');
        }
        
        Presensi::create([
            'user_id' => $user->id,
            'qr_code' => $request->qr_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_at' => now(),
        ]);
    
    
        return redirect()->back()->with('success', 'Presensi berhasil! ' . 'Nama Siswa : ' . $request->qr_code);
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

     /**
     * Haversine formula untuk menghitung jarak antara dua koordinat geografis
     *
     * @param float $lat1 Latitude titik pertama
     * @param float $lon1 Longitude titik pertama
     * @param float $lat2 Latitude titik kedua
     * @param float $lon2 Longitude titik kedua
     * @return float Jarak dalam meter
     */
    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        // Radius bumi dalam meter
        $radius = 6371000;

        // Konversi derajat ke radian
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Perbedaan koordinat
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        // Haversine formula
        $a = sin($dlat / 2) * sin($dlat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Hitung jarak
        $jarak = $radius * $c;

        return $jarak; // Jarak dalam meter
    }
    
}
