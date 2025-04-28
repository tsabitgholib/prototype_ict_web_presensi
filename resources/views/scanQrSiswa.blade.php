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
document.addEventListener("DOMContentLoaded", function () {
    const html5QrCode = new Html5Qrcode("reader");
    let isScanned = false;

    function isMobileDevice() {
        return /Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    const facingMode = isMobileDevice() ? "environment" : "user"; // HP = kamera belakang, Laptop = kamera depan

    html5QrCode.start(
        { facingMode: facingMode },
        { fps: 10, qrbox: 250 },
        async qrCodeMessage => {
            if (isScanned) return;
            isScanned = true;

            console.log("QR Code detected: ", qrCodeMessage);

            if (!qrCodeMessage) {
                alert('QR tidak terbaca!');
                isScanned = false;
                return;
            }

            document.getElementById('qr_code').value = qrCodeMessage;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async function (position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;

                    console.log("Lokasi: ", position.coords.latitude, position.coords.longitude);

                    await html5QrCode.stop().then(() => {
                        document.getElementById('scanForm').submit();
                    }).catch((err) => {
                        alert("Gagal menghentikan scanner: " + err);
                        isScanned = false;
                    });
                }, function (error) {
                    alert('Gagal mendapatkan lokasi: ' + error.message);
                    isScanned = false;
                });
            } else {
                alert("Geolocation tidak didukung oleh browser.");
                isScanned = false;
            }
        },
        errorMessage => {
            // Handle scan error di sini kalau mau
            // console.log("Scan error: ", errorMessage);
        }
    ).catch(err => {
        alert("Gagal memulai kamera: " + err);
    });
});



//     document.addEventListener("DOMContentLoaded", function () {
//     const html5QrCode = new Html5Qrcode("reader");
//     let isScanned = false;

//     html5QrCode.start(
//         { facingMode: "environment" },
//         { fps: 10, qrbox: 250 },
//         async qrCodeMessage => {
//             if (isScanned) return;
//             isScanned = true;

//             console.log("QR Code detected: ", qrCodeMessage);

//             if (!qrCodeMessage) {
//                 alert('QR tidak terbaca!');
//                 isScanned = false;
//                 return;
//             }

//             document.getElementById('qr_code').value = qrCodeMessage;

//             document.getElementById('latitude').value = '';
//             document.getElementById('longitude').value = '';

//             // Submit form langsung setelah scan
//             await html5QrCode.stop().then(() => {
//                 document.getElementById('scanForm').submit();
//             }).catch((err) => {
//                 alert("Gagal menghentikan scanner: " + err);
//                 isScanned = false;
//             });
//         },
//         errorMessage => {
//             // console.log("error: ", errorMessage);
//         }
//     ).catch(err => {
//         alert("Gagal memulai kamera: " + err);
//     });
// });

    </script>
@endpush