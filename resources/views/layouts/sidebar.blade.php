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

    <style>
        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            transition: width 0.3s ease-in-out, left 0.3s ease-in-out;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            background: white;
            overflow-x: hidden;
            left: 0;
            padding: 15px;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        
        .content-expanded {
            margin-left: 170px;
            transition: margin-left 0.3s ease-in-out;
        }
        .content-full {
            margin-left: -50px;
        }

        /* Tombol Toggle */
        .sidebar-toggle {
            cursor: pointer;
            position: absolute;
            top: 15px;
            left: 85%;
            background: none;
            border: none;
            font-size: 24px;
            z-index: 1100;
        }

        /* Styling Icon dan Link */
        .nav-item {
            display: flex;
            align-items: center;
            padding: 10px;
            transition: all 0.3s;
        }

        .nav-item svg {
            width: 24px;
            height: 24px;
            transition: all 0.3s;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: black;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s;
        }

        /* Saat Sidebar Dikecilkan */
        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-item svg {
            transform: translateX(-15px);
        }

        .sidebar.collapsed .nav-item {
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-toggle {
            left: 50%;
            transform: translateX(-50%);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-light">
    <div>
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar p-3 d-flex flex-column">
            <button id="toggleSidebar" class="sidebar-toggle">
                &#9776;
            </button>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a href="{{ route('scan.qr.siswa') }}" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                        </svg>                          
                        <span>Presensi Siswa</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('scan.qr.guru') }}" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                        </svg>                          
                        <span>Presensi Guru</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('presensi.list.siswa') }}" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                          </svg>                          
                        <span>Riwayat Presensi</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Content -->
        <div id="content" class="container-fluid p-4 content-expanded">
            @yield('content')
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#toggleSidebar').click(function() {
                $('#sidebar').toggleClass('collapsed');
                $('#content').toggleClass('content-full content-expanded');
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
