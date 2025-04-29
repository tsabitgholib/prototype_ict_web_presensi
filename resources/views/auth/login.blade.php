@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="modal show d-block shadow-lg rounded-4" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content border-0">
                <div class="modal-body text-center p-5">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('/images/logo1.png') }}" alt="Logo" class="mb-3" style="width: 150px; height: auto;">
                    </div>
                    

                    <h4 class="mb-4 text-dark">Selamat Datang</h4>

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
                            <label for="tipe_login" class="form-label fw-bold">Login Sebagai</label>
                            <select class="form-control form-control-lg" name="tipe_login" id="tipe_login" required>
                                <option value="siswa" {{ old('tipe_login') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="guru" {{ old('tipe_login') == 'guru' ? 'selected' : '' }}>Guru</option>
                            </select>
                        </div>

                        <div class="mb-3 text-start" id="input-id">
                            <label for="identifier" class="form-label fw-bold">NIS</label>
                            <input type="text" class="form-control form-control-lg" name="identifier" id="identifier" placeholder="Masukkan NIS atau NIK" value="{{ old('identifier') }}" required>
                        </div>

                        <div class="mb-3 text-center">
                            <div class="d-flex justify-content-center">
                                <img src="{{ url('/captcha') }}" class="border rounded" style="height: 80px;">
                            </div>
                            <input type="text" class="form-control form-control-lg mt-3 text-center" name="captcha" placeholder="Masukkan Captcha" required>
                        </div>
                    
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill mt-3">Login</button>
                    </form>
                </div>
                
                <div class="modal-footer justify-content-center w-100 bg-white border-0">
                    <small class="text-muted">© {{ date('Y') }} PT. Inovasi Cipta Teknologi</small>
                </div>                
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    document.getElementById('tipe_login').addEventListener('change', function () {
        const label = document.querySelector('label[for="identifier"]');
        label.textContent = this.value === 'guru' ? 'NIK' : 'NIS';
    });
</script>
