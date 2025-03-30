@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="modal show d-block shadow-lg rounded-4" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content border-0">
                <div class="modal-body text-center p-5">
                    <!-- Logo -->
                    <img src="{{ asset('/prototype/prototype_ict_web_presensi/images/logo1.png') }}" alt="Logo" class="mb-3" style="width: 150px; height: auto;">

                    <h4 class="mb-4 text-dark">Selamat Datang</h4>

                    <!-- Error Alert -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3 text-start">
                            <label for="nis" class="form-label fw-bold">NIS</label>
                            <input type="nis" class="form-control form-control-lg" name="nis" id="nis" placeholder="Masukkan NIS" value="{{ old('nis') }}" required>
                        </div>

                        {{-- <div class="mb-3 text-start">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Masukkan Password" required>
                        </div> --}}

                    <!-- Captcha -->
                    <div class="mb-3 text-center">
                        <div class="d-flex justify-content-center">
                            <img src="{{ url('/captcha') }}" class="border rounded" style="height: 80px;">
                        </div>
                        <input type="text" class="form-control form-control-lg mt-3 text-center" name="captcha" placeholder="Masukkan Captcha" required>
                    </div>


                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill mt-3">Login</button>
                    </form>
                </div>
                
                <div class="modal-footer text-center w-100 bg-white border-0">
                    <small class="text-muted">© {{ date('Y') }} Aplikasi Absensi QR</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
