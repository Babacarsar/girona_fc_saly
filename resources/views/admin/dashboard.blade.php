@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4 fw-semibold text-dark">📊 Tableau de bord général</h2>

    {{-- Cartes de Statistiques --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-gradient bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1">{{ $totalJoueurs }}</h3>
                    <p class="mb-0">👟 Joueurs enregistrés</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-gradient bg-success text-white">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1">{{ $totalStaff }}</h3>
                    <p class="mb-0">🧢 Staff technique</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-gradient bg-dark text-white">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1">{{ $totalCategories }}</h3>
                    <p class="mb-0">📁 Catégories</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">📈 Joueurs ajoutés par mois</h5>
                    <canvas id="joueursChart" height="160"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">📊 Répartition par catégorie</h5>
                    <canvas id="categoriesChart" height="160"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Derniers ajouts --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">🕵️ Derniers joueurs ajoutés</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($derniersJoueurs as $joueur)
                            <li class="list-group-item d-flex align-items-center gap-3">
                                <img src="{{ asset($joueur->photo ?? 'https://via.placeholder.com/40x40') }}"
                                     class="rounded-circle" width="45" height="45" alt="photo">
                                <div>
                                    <div class="fw-semibold">{{ $joueur->prenom }} {{ $joueur->nom }}</div>
                                    <small class="text-muted">{{ $joueur->poste }} — {{ $joueur->categorie->nom ?? 'N/A' }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">🧑‍🏫 Derniers membres du staff</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($dernierStaff as $staff)
                            <li class="list-group-item d-flex align-items-center gap-3">
                                <img src="{{ asset($staff->photo ?? 'https://via.placeholder.com/40x40') }}"
                                     class="rounded-circle" width="45" height="45" alt="photo">
                                <div>
                                    <div class="fw-semibold">{{ $staff->prenom }} {{ $staff->nom }}</div>
                                    <small class="text-muted">{{ $staff->role }} — {{ $staff->categorie->nom ?? 'N/A' }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('joueursChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($joueursParMois)) !!},
            datasets: [{
                label: 'Joueurs ajoutés',
                data: {!! json_encode(array_values($joueursParMois)) !!},
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    new Chart(document.getElementById('categoriesChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($joueursParCategorie)) !!},
            datasets: [{
                label: 'Nombre de joueurs',
                data: {!! json_encode(array_values($joueursParCategorie)) !!},
                backgroundColor: '#198754'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection
