@extends('layouts.admin')

@section('title', 'Actualités')

@section('content')
<x-admin.page-header title="Actualités" description="Brouillon vs publié · ordre · à la une.">
    <x-slot:actions>
        <a href="{{ route('admin.actualites.create') }}" class="btn btn-girona"><i class="bi bi-plus-lg me-1"></i> Publier</a>
    </x-slot:actions>
</x-admin.page-header>

<form id="actualites-reorder-form" method="POST" action="{{ route('admin.actualites.reorder') }}" class="d-none">@csrf</form>

<div class="admin-card">
    <div class="admin-card__body">
        <form method="GET" class="admin-toolbar mb-3">
            <select name="statut" class="form-select" style="max-width:200px" onchange="this.form.submit()">
                <option value="">Tous statuts</option>
                <option value="published" @selected(request('statut') === 'published')>Publiées</option>
                <option value="draft" @selected(request('statut') === 'draft')>Brouillons</option>
            </select>
        </form>

        @if($actualites->count() && !request('statut'))
            <button type="submit" form="actualites-reorder-form" class="btn btn-girona-outline btn-sm mb-3">
                <i class="bi bi-save me-1"></i> Enregistrer l’ordre
            </button>
        @endif

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:40px"></th>
                        <th><x-admin.sort-link field="titre" label="Titre" default="ordre" /></th>
                        <th>Statut</th>
                        <th>À la une</th>
                        <th><x-admin.sort-link field="ordre" label="Ordre" default="ordre" /></th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody data-reorder-body data-reorder-form="actualites-reorder-form">
                    @forelse ($actualites as $actu)
                        <tr data-id="{{ $actu->id }}">
                            <td><span class="reorder-handle"><i class="bi bi-grip-vertical"></i></span></td>
                            <td class="fw-semibold">{{ $actu->titre }}</td>
                            <td>
                                @if($actu->statut === 'published')
                                    <span class="badge bg-success">Publié</span>
                                @else
                                    <span class="badge bg-secondary">Brouillon</span>
                                @endif
                            </td>
                            <td>@if($actu->a_la_une)<i class="bi bi-star-fill text-warning"></i>@else—@endif</td>
                            <td>{{ $actu->ordre }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.actualites.edit', $actu) }}" class="btn btn-sm btn-girona-outline"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.actualites.destroy', $actu) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-admin-delete="Supprimer ?"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="admin-empty">Aucune actualité.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $actualites->links() }}</div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="{{ asset('js/reorder.js') }}?v=1"></script>
@endpush
