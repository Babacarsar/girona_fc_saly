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

        @error('bulk')
            <div class="alert alert-danger py-2">{{ $message }}</div>
        @enderror

        <div id="joueurs-bulk-bar" class="alert alert-light border d-none d-flex flex-wrap align-items-center gap-2 mb-3 py-2">
            <span class="small fw-semibold me-2"><span id="joueurs-bulk-count">0</span> sélectionné(s)</span>
            <button type="button" class="btn btn-sm btn-girona-outline" data-bs-toggle="modal" data-bs-target="#joueursBulkEditModal">
                <i class="bi bi-pencil me-1"></i> Modifier
            </button>
            <button type="submit" form="joueurs-bulk-photos-form" class="btn btn-sm btn-girona">
                <i class="bi bi-camera me-1"></i> Photos
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger" id="joueurs-bulk-delete-btn">
                <i class="bi bi-trash me-1"></i> Supprimer
            </button>
        </div>

        @if(!$joueurs->isEmpty() && !request()->hasAny(['q', 'categorie_id']))
            <button type="submit" form="joueurs-reorder-form" class="btn btn-girona-outline btn-sm mb-3">
                <i class="bi bi-save me-1"></i> Enregistrer l’ordre
            </button>
        @endif

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:36px">
                            <input type="checkbox" class="form-check-input" id="joueurs-select-all" aria-label="Tout sélectionner">
                        </th>
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
                            <td>
                                <input type="checkbox" class="form-check-input joueur-select" value="{{ $joueur->id }}" aria-label="Sélectionner {{ $joueur->prenom }} {{ $joueur->nom }}">
                            </td>
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
                        <tr><td colspan="7"><div class="admin-empty">Aucun joueur.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $joueurs->links() }}</div>
    </div>
</div>

<form id="joueurs-bulk-photos-form" method="POST" action="{{ route('admin.joueurs.bulk_photos.edit') }}" class="d-none">
    @csrf
    @foreach(request()->only(['q', 'categorie_id', 'page']) as $key => $val)
        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
    @endforeach
</form>

<form id="joueurs-bulk-delete-form" method="POST" action="{{ route('admin.joueurs.bulk_destroy') }}" class="d-none">
    @csrf
    @foreach(request()->only(['q', 'categorie_id', 'page']) as $key => $val)
        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
    @endforeach
</form>

<div class="modal fade" id="joueursBulkEditModal" tabindex="-1" aria-labelledby="joueursBulkEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="joueurs-bulk-update-form" method="POST" action="{{ route('admin.joueurs.bulk_update') }}">
                @csrf
                @method('PUT')
                @foreach(request()->only(['q', 'categorie_id', 'page']) as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <div class="modal-header">
                    <h5 class="modal-title" id="joueursBulkEditModalLabel">Modifier la sélection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body admin-form">
                    <p class="text-muted small">Les champs laissés vides ne seront pas modifiés.</p>
                    <div class="mb-3">
                        <label class="form-label">Catégorie</label>
                        <select name="categorie_id" class="form-select">
                            <option value="">— Ne pas changer —</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Poste</label>
                        <input type="text" name="poste" class="form-control" placeholder="Ex. Gardien, Milieu…">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-girona">Appliquer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="{{ asset('js/reorder.js') }}?v=1"></script>
<script src="{{ asset('js/joueurs-bulk.js') }}?v=1"></script>
@endpush
