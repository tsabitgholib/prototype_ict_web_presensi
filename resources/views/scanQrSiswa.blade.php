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
        <video id="preview" class="w-100"></video>
    </div>

    <form id="scanForm" action="{{ route('presensi.siswa') }}" method="post" class="d-none">
        @csrf
        <input type="hidden" name="qr_code" id="qr_code">
    </form>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/schmich/instascan-builds@master/instascan.min.js"></script>
<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content) {
        document.getElementById('qr_code').value = content;
        document.getElementById('scanForm').submit();
    });

    Instascan.Camera.getCameras().then(cameras => {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('No cameras found.');
        }
    }).catch(console.error);
</script>
@endpush
