@extends('layouts.sidebar')

@section('title', 'Scan QR - Presensi')

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center min-vh-100">
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

    <h2 class="text-3xl text-black-700 text-center mb-4">
        Silahkan Scan QR di Sini
    </h2>
    
    <div class="border border-dark rounded p-3 bg-black">
        <div id="reader" style="width: 500px"></div>
    </div>

    <form id="scanForm" action="{{ route('presensi.siswa') }}" method="post" class="d-none">
        @csrf
        <input type="hidden" name="qr_code" id="qr_code">
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/html5-qrcode.min.js') }}"></script>

<script>
    const html5QrCode = new Html5Qrcode("reader");

    function startScanner() {
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            qrCodeMessage => {
                document.getElementById('qr_code').value = qrCodeMessage;

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;

                        // Setelah data lengkap, submit form
                        document.getElementById('scanForm').submit();
                    }, function(error) {
                        alert('Gagal mendapatkan lokasi: ' + error.message);
                    });
                } else {
                    alert("Geolocation tidak didukung oleh browser ini.");
                }
            },
            errorMessage => {
                // Optional: console.log(errorMessage);
            }
        ).catch(err => {
            alert("Gagal memulai kamera: " + err);
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        startScanner();
    });
</script>

<!-- (Optional) Map code tetap kalau ingin dipakai -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            var map = L.map('map').setView([lat, lon], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            L.marker([lat, lon]).addTo(map)
                .bindPopup("Lokasi Anda")
                .openPopup();

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;
        });
    }

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
@endpush
