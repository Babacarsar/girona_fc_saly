<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Club Foot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    {{-- Icônes Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
        }

        .sidebar {
            background: white;
            height: 100vh;
            border-right: 1px solid #dee2e6;
            padding: 1.5rem 1rem;
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
            padding: 10px 15px;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #0d6efd;
            color: white;
        }

        .content-area {
            padding: 2rem;
            width: 100%;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                width: 200px;
                left: -200px;
                transition: left 0.3s;
            }

            .sidebar.show {
                left: 0;
            }

            .menu-toggle {
                display: inline-block;
                cursor: pointer;
            }
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-dark bg-dark sticky-top px-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <span class="menu-toggle text-white d-md-none"><i class="bi bi-list fs-3"></i></span>
            <span class="navbar-brand">⚽ Girona de Saly</span>
        </div>
        <span class="text-white small">Bienvenue, Admin</span>
    </nav>

    {{-- Layout --}}
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar" id="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.joueurs.index') }}" class="nav-link {{ request()->is('admin/joueurs*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge me-2"></i> Joueurs
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.staff.index') }}" class="nav-link {{ request()->is('admin/staff*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill me-2"></i> Staff technique
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                        <i class="bi bi-folder2-open me-2"></i> Catégories
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.actualites.index') }}" class="nav-link {{ request()->is('admin/actualites*') ? 'active' : '' }}">
                        <i class="bi bi-newspaper me-2"></i> Actualités
                    </a>
                </li>
                <li class="nav-item">
    <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->is('admin/media*') ? 'active' : '' }}">
        <i class="bi bi-image me-2"></i> Médias
    </a>
</li>

            </ul>
        </div>

        {{-- Main Content --}}
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    {{-- JS --}}
    <script>
        document.querySelector('.menu-toggle')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>

</body>
</html>
