@extends('layouts.sidebar')

@section('content')
<div class="container" style="margin-top: 50px">
    <h1 style="text-align: center">Presensi Siswa</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning text-center">
            {{ session('warning') }}
        </div>
    @endif

    <!-- Peta Lokasi -->
    <div id="map" style="height: 300px; margin-top: 20px; text-align: center"></div>
    
    <form id="attendanceForm" action="{{ route('presensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        
        <div style="text-align: center; margin-top: 20px;">
            <button type="button" onclick="getLocationAndSubmitForm()">Presensi</button>
          </div>
          
    </form>
</div>

<!-- CDN Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            // Menampilkan peta dengan koordinat pengguna
            var map = L.map('map').setView([lat, lon], 13);

            // Menambahkan tile layer OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Menambahkan marker untuk lokasi pengguna
            L.marker([lat, lon]).addTo(map)
                .bindPopup("Lokasi Anda")
                .openPopup();

            // Menyimpan koordinat ke form tersembunyi
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;
        });
    } else {
        alert("Geolocation tidak didukung oleh browser ini.");
    }

    // Fungsi untuk mengambil lokasi dan submit form
    function getLocationAndSubmitForm() {
        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;

        if (latitude && longitude) {
            document.getElementById('attendanceForm').submit();
        } else {
            alert('Lokasi tidak ditemukan!');
        }
    }
</script>
@endsection
