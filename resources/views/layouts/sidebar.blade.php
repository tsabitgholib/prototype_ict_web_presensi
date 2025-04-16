<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Presensi Siswa')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Bootstrap & jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        /* ========== Sidebar ========== */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: white;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1040;
            transition: transform 0.3s ease;
            padding: 15px;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.mobile-hidden {
            transform: translateX(-100%);
        }

        /* ========== Content Area ========== */
        .content {
            transition: margin-left 0.3s ease;
            padding: 20px;
        }

        @media (min-width: 769px) {
            .content.expanded {
                margin-left: 250px;
            }

            .content.collapsed {
                margin-left: 80px;
            }
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0 !important;
            }
        }

        /* ========== Toggle Button ========== */
        .sidebar-toggle {
            font-size: 24px;
            border: none;
            background: white;
            padding: 5px 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            cursor: pointer;
        }

        .sidebar-toggle.d-md-none {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1100;
        }

        .sidebar-toggle.d-none.d-md-block {
            margin-bottom: 20px;
        }

        /* ========== Sidebar Items ========== */
        .nav-item {
            display: flex;
            align-items: center;
            padding: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: black;
            text-decoration: none;
            font-size: 16px;
        }

        .nav-item svg {
            width: 24px;
            height: 24px;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-item {
            justify-content: center;
        }

        .sidebar.collapsed .nav-item svg {
            transform: translateX(-5px);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-light">

    <!-- Toggle for Mobile -->
    <button id="toggleSidebarMobile" class="sidebar-toggle d-md-none">
        &#9776;
    </button>

    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <!-- Toggle for Desktop -->
        <button id="toggleSidebarDesktop" class="sidebar-toggle d-none d-md-block">
            &#9776;
        </button>

        <ul class="nav flex-column mt-2">
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
                <a href="{{ route('presensi.create') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                      </svg>                                            
                    <span>Presensi Map</span>
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
    <div id="content" class="content expanded">
        @yield('content')
    </div>

    <script>
        $(document).ready(function () {
            function updateLayout() {
                const isMobile = window.innerWidth <= 768;
                if (isMobile) {
                    $('#sidebar').addClass('mobile-hidden');
                    $('#content').removeClass('expanded collapsed');
                } else {
                    $('#sidebar').removeClass('mobile-hidden');
                    $('#sidebar').removeClass('collapsed');
                    $('#content').addClass('expanded').removeClass('collapsed');
                }
            }

            updateLayout();

            $('#toggleSidebarMobile').on('click', function () {
                $('#sidebar').toggleClass('mobile-hidden');
            });

            $('#toggleSidebarDesktop').on('click', function () {
                $('#sidebar').toggleClass('collapsed');
                $('#content').toggleClass('collapsed expanded');
            });

            $(window).on('resize', updateLayout);
        });
    </script>

    @stack('scripts')
</body>
</html>
