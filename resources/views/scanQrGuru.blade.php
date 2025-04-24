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

    <form id="scanForm" action="{{ route('presensi.guru') }}" method="post" class="d-none">
        @csrf
        <input type="hidden" name="qr_code" id="qr_code">
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
    </form>

<div class="container mt-4">

    <h2 class="text-center font-lg mb-4">Daftar Presensi</h2>

    {{-- <form method="GET" action="{{ route('absensi.list') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form> --}}

    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($presensis as $a)
                <tr>
                    <td>{{ $a->user->name }}</td>
                    <td>{{ $a->created_at }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">Belum ada Presensi hari ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const html5QrCode = new Html5Qrcode("reader");
    let isScanned = false;

    // Start scanning
    html5QrCode.start(
        { facingMode: "environment" }, // Use environment camera (back camera)
        { fps: 10, qrbox: 250 }, // Set frames per second and QR box size
        async qrCodeMessage => {
            if (isScanned) return; // Prevent duplicate scanning
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

                    // Automatically submit the form after scanning
                    document.getElementById('scanForm').submit();

                    // Reset the scanner to scan again without waiting for the camera to move
                    isScanned = false;
                    html5QrCode.start(
                        { facingMode: "environment" },
                        { fps: 10, qrbox: 250 },
                        async nextQrCodeMessage => {
                            if (!isScanned && nextQrCodeMessage) {
                                document.getElementById('qr_code').value = nextQrCodeMessage;
                                document.getElementById('scanForm').submit();
                            }
                        },
                        errorMessage => {
                            // Handle any scanning errors
                        }
                    );
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
            // Handle scanner errors
            console.log("Error scanning: ", errorMessage);
        }
    ).catch(err => {
        alert("Gagal memulai kamera: " + err);
    });
});


</script>
@endpush
