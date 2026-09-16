@extends('layouts.admin')

@section('title', 'Joueurs')

@section('content')
<x-admin.page-header title="Joueurs" description="Glissez les lignes pour définir l’ordre d’affichage sur le site.">
    <x-slot:actions>
        <a href="{{ route('admin.joueurs.create') }}" class="btn btn-girona"><i class="bi bi-plus-lg me-1"></i> Ajouter</a>
    </x-slot:actions>
</x-admin.page-header>

<form id="joueurs-reorder-form" method="POST" action="{{ route('admin.joueurs.reorder') }}" class="d-none">@csrf</form>

<div class="admin-card">
    <div class="admin-card__body">
        <form method="GET" class="admin-toolbar">
            <div class="admin-search">
                <i class="bi bi-search"></i>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher…">
            </div>
            <select name="categorie_id" class="form-select" style="max-width:220px" onchange="this.form.submit()">
                <option value="">Toutes catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($selectedCategorie == $cat->id)>{{ $cat->nom }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-light">Filtrer</button>
        </form>

        @if(!$joueurs->isEmpty() && !request()->hasAny(['q', 'categorie_id']))
            <button type="submit" form="joueurs-reorder-form" class="btn btn-girona-outline btn-sm mb-3">
                <i class="bi bi-save me-1"></i> Enregistrer l’ordre
            </button>
        @endif

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:40px"></th>
                        <th><x-admin.sort-link field="nom" label="Joueur" /></th>
                        <th><x-admin.sort-link field="poste" label="Poste" default="ordre" /></th>
                        <th>Catégorie</th>
                        <th><x-admin.sort-link field="ordre" label="Ordre" default="ordre" /></th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody data-reorder-body data-reorder-form="joueurs-reorder-form">
                    @forelse($joueurs as $joueur)
                        <tr data-id="{{ $joueur->id }}">
                            <td><span class="reorder-handle text-muted cursor-grab"><i class="bi bi-grip-vertical"></i></span></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ admin_media_url($joueur->photo, $joueur->prenom.'+'.$joueur->nom) }}" alt="" class="admin-avatar">
                                    <span class="fw-semibold">{{ $joueur->prenom }} {{ $joueur->nom }}</span>
                                </div>
                            </td>
                            <td>{{ $joueur->poste ?? '—' }}</td>
                            <td><span class="badge badge-girona">{{ $joueur->categorie->nom ?? 'N/A' }}</span></td>
                            <td>{{ $joueur->ordre }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="btn btn-sm btn-girona-outline"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.joueurs.destroy', $joueur) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-admin-delete="Supprimer ce joueur ?"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="admin-empty">Aucun joueur.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $joueurs->links() }}</div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="{{ asset('js/reorder.js') }}?v=1"></script>
@endpush
