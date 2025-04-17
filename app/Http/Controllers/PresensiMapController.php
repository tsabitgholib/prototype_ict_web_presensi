<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;

class PresensiMapController extends Controller
{
    protected $latitudeSekolah = -6.9677;
    protected $longitudeSekolah = 110.2458;
    // protected $latitudeSekolah = -6.98749480;
    // protected $longitudeSekolah = 110.43590270;
    protected $radiusMax = 100;

    public function create()
    {
        return view('presensiMap');
    }

    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $latitudeUser = $request->latitude;
        $longitudeUser = $request->longitude;

        //hitung jarak antara lokasi user dan lokasi sekolah
        $jarak = $this->haversine($this->latitudeSekolah, $this->longitudeSekolah, $latitudeUser, $longitudeUser);

        $user = auth()->user();
    
        $sudahPresensi = Presensi::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->exists();
    
        // if ($sudahPresensi) {
        //     return redirect()->back()->with('warning', $user->name . ', Anda sudah presensi hari ini!');
        // }
    

        if ($jarak > $this->radiusMax) {
            return redirect()->route('presensi.create')->with('error', 'Anda terlalu jauh dari lokasi presensi!');
        }

        Presensi::create([
            'user_id' => auth()->id(),
            'latitude' => $latitudeUser,
            'longitude' => $longitudeUser,
        ]);

        return redirect()->route('presensi.create')->with('success', 'Presensi berhasil!');
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
