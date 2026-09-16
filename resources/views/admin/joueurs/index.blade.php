@extends('layouts.admin')

@section('title', 'Joueurs')

@section('content')
<x-admin.page-header
    title="Joueurs"
    description="Gérez l’effectif par catégorie, poste et photo."
>
    <x-slot:actions>
        <a href="{{ route('admin.joueurs.create') }}" class="btn btn-girona">
            <i class="bi bi-plus-lg me-1"></i> Ajouter un joueur
        </a>
    </x-slot:actions>
</x-admin.page-header>

<div class="admin-card">
    <div class="admin-card__body">
        <form method="GET" class="admin-toolbar">
            <div class="admin-search">
                <i class="bi bi-search"></i>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher nom, prénom, poste…">
            </div>
            <select name="categorie_id" class="form-select" style="max-width: 220px" onchange="this.form.submit()">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($selectedCategorie == $cat->id)>{{ $cat->nom }}</option>
                @endforeach
            </select>
            @if(request('q') || request('categorie_id'))
                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-light">Réinitialiser</a>
            @endif
        </form>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Joueur</th>
                        <th>Poste</th>
                        <th>Catégorie</th>
                        <th>Âge</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($joueurs as $joueur)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ admin_media_url($joueur->photo, $joueur->prenom.'+'.$joueur->nom) }}" alt="" class="admin-avatar">
                                    <div>
                                        <div class="fw-semibold">{{ $joueur->prenom }} {{ $joueur->nom }}</div>
                                        <small class="text-muted">#{{ $joueur->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $joueur->poste ?? '—' }}</td>
                            <td><span class="badge badge-girona">{{ $joueur->categorie->nom ?? 'N/A' }}</span></td>
                            <td>{{ $joueur->age ?? '—' }}</td>
                            <td class="text-end">
                                <div class="admin-actions justify-content-end">
                                    <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="btn btn-sm btn-girona-outline">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.joueurs.destroy', $joueur) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-admin-delete="Supprimer {{ $joueur->prenom }} {{ $joueur->nom }} ?">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="admin-empty">
                                    <i class="bi bi-person-x"></i>
                                    Aucun joueur trouvé. <a href="{{ route('admin.joueurs.create') }}">Créer le premier</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
