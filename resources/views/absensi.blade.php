@extends('layouts.app')

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

    <h2 class="text-center mb-4">Daftar Absensi</h2>

    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensis as $a)
                <tr>
                    <td>{{ $a->user->name }}</td>
                    <td>{{ $a->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
