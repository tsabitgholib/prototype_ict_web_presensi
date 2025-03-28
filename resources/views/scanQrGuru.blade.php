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

    <form id="scanForm" action="{{ route('presensi.guru') }}" method="post" class="d-none">
        @csrf
        <input type="hidden" name="qr_code" id="qr_code">
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
