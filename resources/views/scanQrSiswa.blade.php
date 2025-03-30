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

    <button id="startScan" class="btn btn-primary mt-3">Mulai Scan</button>

    <form id="scanForm" action="{{ route('presensi.siswa') }}" method="post" class="d-none">
        @csrf
        <input type="hidden" name="qr_code" id="qr_code">
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/@zxing/library@latest"></script>
<script>
    document.getElementById('startScan').addEventListener('click', function() {
        let selectedDeviceId;
        const codeReader = new ZXing.BrowserQRCodeReader();

        codeReader.getVideoInputDevices()
            .then(videoInputDevices => {
                if (videoInputDevices.length > 0) {
                    selectedDeviceId = videoInputDevices[0].deviceId;
                    return codeReader.decodeFromVideoDevice(selectedDeviceId, 'preview', (result, err) => {
                        if (result) {
                            document.getElementById('qr_code').value = result.text;
                            document.getElementById('scanForm').submit();
                        }
                    });
                } else {
                    alert('Kamera tidak ditemukan.');
                }
            })
            .catch(err => console.error(err));
    });
</script>
@endpush
