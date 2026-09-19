@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<x-admin.page-header
    title="Tableau de bord"
    description="Vue d’ensemble de l’académie Girona de Saly — effectifs, contenus et tendances."
/>

<div class="admin-stat-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon"><i class="bi bi-person-badge"></i></div>
        <p class="admin-stat-card__value">{{ $totalJoueurs }}</p>
        <p class="admin-stat-card__label">Joueurs inscrits</p>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon"><i class="bi bi-people"></i></div>
        <p class="admin-stat-card__value">{{ $totalStaff }}</p>
        <p class="admin-stat-card__label">Staff technique</p>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon"><i class="bi bi-layers"></i></div>
        <p class="admin-stat-card__value">{{ $totalCategories }}</p>
        <p class="admin-stat-card__label">Catégories</p>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon"><i class="bi bi-megaphone"></i></div>
        <p class="admin-stat-card__value">{{ $totalActualites }}</p>
        <p class="admin-stat-card__label">Actualités</p>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon"><i class="bi bi-camera-reels"></i></div>
        <p class="admin-stat-card__value">{{ $totalMedia }}</p>
        <p class="admin-stat-card__label">Médias</p>
    </div>
</div>

<div class="admin-card mb-4">
    <div class="admin-card__header">
        <h2 class="admin-card__title">Actions rapides</h2>
    </div>
    <div class="admin-card__body">
        <div class="admin-quick-links">
            <a href="{{ route('admin.joueurs.create') }}" class="admin-quick-link">
                <i class="bi bi-person-plus-fill"></i> Nouveau joueur
            </a>
            <a href="{{ route('admin.staff.create') }}" class="admin-quick-link">
                <i class="bi bi-person-workspace"></i> Nouveau staff
            </a>
            <a href="{{ route('admin.actualites.create') }}" class="admin-quick-link">
                <i class="bi bi-newspaper"></i> Publier actu
            </a>
            <a href="{{ route('admin.media.create') }}" class="admin-quick-link">
                <i class="bi bi-cloud-upload"></i> Ajouter média
            </a>
        </div>
        <form action="{{ route('admin.roster_import') }}" method="POST" class="mt-4 pt-3 border-top" onsubmit="return confirm('Remplacer TOUTES les catégories et joueurs (et vider staff / pré-inscriptions) par l’effectif Excel officiel ?');">
            @csrf
            <input type="hidden" name="confirm" value="import">
            <button type="submit" class="btn btn-girona btn-sm">
                <i class="bi bi-file-earmark-spreadsheet"></i> Importer effectif Excel (U13/U15)
            </button>
            <span class="text-muted small ms-2">Catégories U13, U15, U17, U19 — données <code>girona_roster.json</code>.</span>
        </form>
        <form action="{{ route('admin.demo_seed') }}" method="POST" class="mt-3" onsubmit="return confirm('Charger / compléter les données de démo (joueurs, actus, photos URL…) ?');">
            @csrf
            <input type="hidden" name="confirm" value="demo">
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-database-add"></i> Données de démonstration
            </button>
            <span class="text-muted small ms-2">Mock avec images (sans Cloudinary). Ré-exécutable.</span>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card__header">
                <h2 class="admin-card__title">Inscriptions (12 mois)</h2>
            </div>
            <div class="admin-card__body">
                <canvas id="joueursChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card__header">
                <h2 class="admin-card__title">Joueurs par catégorie</h2>
            </div>
            <div class="admin-card__body">
                <canvas id="categoriesChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card__header">
                <h2 class="admin-card__title">Derniers joueurs</h2>
                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-sm btn-girona-outline">Tout voir</a>
            </div>
            <div class="admin-card__body pt-2">
                @forelse ($derniersJoueurs as $joueur)
                    <div class="admin-list-item">
                        <img src="{{ admin_media_url($joueur->photo, $joueur->prenom.'+'.$joueur->nom) }}" alt="" class="admin-avatar">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $joueur->prenom }} {{ $joueur->nom }}</div>
                            <small class="text-muted">{{ $joueur->poste }} · {{ $joueur->categorie->nom ?? '—' }}</small>
                        </div>
                    </div>
                @empty
                    <div class="admin-empty"><i class="bi bi-inbox"></i>Aucun joueur pour le moment.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card__header">
                <h2 class="admin-card__title">Staff récent</h2>
                <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-girona-outline">Tout voir</a>
            </div>
            <div class="admin-card__body pt-2">
                @forelse ($dernierStaff as $staff)
                    <div class="admin-list-item">
                        <img src="{{ admin_media_url($staff->photo, $staff->prenom.'+'.$staff->nom) }}" alt="" class="admin-avatar">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $staff->prenom }} {{ $staff->nom }}</div>
                            <small class="text-muted">{{ $staff->role }} · {{ $staff->categorie->nom ?? '—' }}</small>
                        </div>
                    </div>
                @empty
                    <div class="admin-empty"><i class="bi bi-inbox"></i>Aucun membre staff.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card__header">
                <h2 class="admin-card__title">Actualités récentes</h2>
                <a href="{{ route('admin.actualites.index') }}" class="btn btn-sm btn-girona-outline">Tout voir</a>
            </div>
            <div class="admin-card__body pt-2">
                @forelse ($dernieresActualites as $actu)
                    <div class="admin-list-item">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ Str::limit($actu->titre, 40) }}</div>
                            <small class="text-muted">{{ $actu->created_at->diffForHumans() }}</small>
                        </div>
                        <a href="{{ route('admin.actualites.edit', $actu) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                    </div>
                @empty
                    <div class="admin-empty"><i class="bi bi-inbox"></i>Aucune actualité.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const red = '#c8102e';
    const redSoft = 'rgba(200, 16, 46, 0.12)';

    new Chart(document.getElementById('joueursChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($joueursParMois)) !!},
            datasets: [{
                label: 'Joueurs',
                data: {!! json_encode(array_values($joueursParMois)) !!},
                borderColor: red,
                backgroundColor: redSoft,
                tension: 0.35,
                fill: true,
                pointBackgroundColor: red,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });

    new Chart(document.getElementById('categoriesChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($joueursParCategorie)) !!},
            datasets: [{
                data: {!! json_encode(array_values($joueursParCategorie)) !!},
                backgroundColor: ['#c8102e', '#ff6b6b', '#1c1c1e', '#f4a261', '#2a9d8f', '#457b9d'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endpush
