<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use GeoIP;
use Illuminate\Support\Facades\Auth;

class PresensiSiswaController extends Controller
{

    protected $latitudeSekolah = -6.9677;
    protected $longitudeSekolah = 110.2458;
    // protected $latitudeSekolah = -6.98749480;
    // protected $longitudeSekolah = 110.43590270;
    protected $radiusMax = 100;

    public function scanQrSiswa()
    {
        return view('scanQrSiswa');
    }

    public function presensiSiswa(Request $request)
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

        // if ($jarak > $this->radiusMax) {
        //     return redirect()->back()->with('warning', 'Anda terlalu jauh dari lokasi presensi!');
        // }

        if ($sudahPresensi) {
            return redirect()->back()->with('warning', $user->nama . ', Anda sudah presensi hari ini!');
        }

        Presensi::create([
            'user_id' => $user->id,
            'qr_code' => $request->qr_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_at' => now(),
        ]);

        return redirect()->route('presensi.list.siswa')->with('success', 'Presensi berhasil!');


        // GEO IP
        // $qr_code = $request->input('qr_code');

        // $location = geoip()->getLocation();

        // $latitude = $location->lat;
        // $longitude = $location->lon;

        // $jarak = $this->haversine($this->latitudeSekolah, $this->longitudeSekolah, $latitude, $longitude);

        // $sudahPresensi = Presensi::where('user_id', $user->id)
        //     ->whereDate('created_at', today())
        //     ->exists();

        // if ($jarak > $this->radiusMax) {
        //     return redirect()->back()->with('warning', 'Anda terlalu jauh dari lokasi presensi!');
        // }

        // if ($sudahPresensi) {
        //     return redirect()->back()->with('warning', $user->name . ', Anda sudah presensi hari ini!');
        // }

        // $presensi = new Presensi([
        //     'qr_code' => $qr_code,
        //     'latitude' => $latitude,
        //     'longitude' => $longitude,
        // ]);
        // $presensi->save();

        // return redirect()->route('presensi.siswa')->with('success', 'Presensi berhasil!');
    }


    public function presensiListSiswa()
    {
        $user = auth()->user();

        $presensis = Presensi::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

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
