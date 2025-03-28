{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Presensi Siswa')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex">
        <div class="container-fluid p-4">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>