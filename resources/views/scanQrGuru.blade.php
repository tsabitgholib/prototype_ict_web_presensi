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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const html5QrCode = new Html5Qrcode("reader");
        let isScanned = false;

        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            async qrCodeMessage => {
                if (isScanned) return;
                isScanned = true;

                if (!qrCodeMessage) {
                    Swal.fire("QR tidak terbaca!");
                    isScanned = false;
                    return;
                }

                document.getElementById('qr_code').value = qrCodeMessage;

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(async function (position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;

                        const formData = new FormData(document.getElementById('scanForm'));

                        try {
                            const response = await fetch("{{ route('presensi.guru') }}", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: formData
                            });

                            const result = await response.json();

                            if (result.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: result.message || 'Presensi berhasil.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Peringatan!',
                                    text: result.message || 'Presensi gagal.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        } catch (err) {
                            Swal.fire("Terjadi kesalahan saat mengirim data.");
                            console.error(err);
                        }

                        // Reset agar scanner bisa baca QR lagi setelah 2 detik
                        setTimeout(() => {
                            isScanned = false;
                        }, 2000);
                    }, function (error) {
                        Swal.fire('Gagal mendapatkan lokasi: ' + error.message);
                        isScanned = false;
                    });
                } else {
                    Swal.fire("Geolocation tidak didukung oleh browser.");
                    isScanned = false;
                }
            },
            errorMessage => {
                // Bisa tampilkan log error scanning jika perlu
            }
        ).catch(err => {
            Swal.fire("Gagal memulai kamera: " + err);
        });
    });
</script>
@endpush
