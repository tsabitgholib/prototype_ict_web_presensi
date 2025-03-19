<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col items-center justify-center h-screen bg-gray-100">
    
    <!-- Judul -->
    <h2 class="text-xl font-bold text-gray-700 mb-4">Silahkan Scan QR di Sini</h2>

    <!-- Kamera -->
    <div class="relative flex items-center justify-center w-full max-w-lg h-100 
                rounded-lg overflow-hidden shadow-2xl border-4 border-white ring-4 ring-white/50 bg-black">
        <video id="preview" class="w-full h-full"></video>
    </div>

    <form id="scanForm" action="{{ route('absen') }}" method="post" class="hidden">
        @csrf
        <input type="hidden" name="qr_code" id="qr_code">
    </form>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
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
</body>
</html>
