<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin') — Girona de Saly</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#c8102e">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}?v=1" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-app">

<div id="adminSidebarBackdrop" class="admin-sidebar-backdrop"></div>

<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar__brand">
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__logo">
                <div class="admin-sidebar__emblem">GS</div>
                <div>
                    <p class="admin-sidebar__title">Girona de Saly</p>
                    <p class="admin-sidebar__subtitle">Centre de contrôle</p>
                </div>
            </a>
        </div>

        <nav class="admin-nav">
            <div class="admin-nav__label">Navigation</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.joueurs.index') }}" class="admin-nav__link {{ request()->is('admin/joueurs*') ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill"></i> Joueurs
            </a>
            <a href="{{ route('admin.staff.index') }}" class="admin-nav__link {{ request()->is('admin/staff*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Staff technique
            </a>
            <a href="{{ route('admin.categories.index') }}" class="admin-nav__link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="bi bi-layers-fill"></i> Catégories
            </a>

            <div class="admin-nav__label">Contenu</div>
            <a href="{{ route('admin.actualites.index') }}" class="admin-nav__link {{ request()->is('admin/actualites*') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill"></i> Actualités
            </a>
            <a href="{{ route('admin.media.index') }}" class="admin-nav__link {{ request()->is('admin/media*') ? 'active' : '' }}">
                <i class="bi bi-images"></i> Médias
            </a>
        </nav>

        <div class="admin-sidebar__footer">
            Académie · Rouge &amp; blanc<br>
            <a href="{{ url('/api/joueurs') }}" class="text-white-50" target="_blank" rel="noopener">Voir l’API publique</a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <button type="button" class="admin-topbar__toggle" id="adminSidebarToggle" aria-label="Menu">
                <i class="bi bi-list"></i>
            </button>
            <div class="admin-topbar__meta ms-auto">
                <span class="admin-badge-live">Production</span>
                <span class="text-muted small d-none d-md-inline">{{ now()->translatedFormat('l j F Y') }}</span>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="admin-toast-container">
                    <div class="toast align-items-center text-bg-success border-0 auto-show" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<div class="modal fade" id="adminDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmer la suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="adminDeleteMessage" class="mb-0 text-muted"></p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" data-confirm-delete>Supprimer</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}?v=1"></script>
@stack('scripts')
</body>
</html>
