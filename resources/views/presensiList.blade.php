@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    
    <!-- Notifikasi Sukses -->
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

    <h2 class="text-center text-2xl font-bold text-gray-800 mb-6 border-b-2 border-gray-300 pb-2">
        Daftar Presensi
    </h2>
    

    <form method="GET" action="{{ route('presensi.list.siswa') }}" class="mb-4">
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
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>qr</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($presensis as $p)
                <tr>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->qr_code }}</td>
                    <td>{{ $p->created_at }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">Tidak ada data absensi dalam rentang tanggal yang dipilih.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
