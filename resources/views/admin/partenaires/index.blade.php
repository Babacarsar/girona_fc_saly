@extends('layouts.admin')
@section('title', 'Partenaires')
@section('content')
<x-admin.page-header title="Partenaires">
    <x-slot:actions><a href="{{ route('admin.partenaires.create') }}" class="btn btn-girona">Ajouter</a></x-slot:actions>
</x-admin.page-header>
<form id="partenaires-reorder-form" method="POST" action="{{ route('admin.partenaires.reorder') }}" class="d-none">@csrf</form>
<div class="admin-card"><div class="admin-card__body">
<button type="submit" form="partenaires-reorder-form" class="btn btn-girona-outline btn-sm mb-3">Enregistrer l’ordre</button>
<table class="admin-table"><thead><tr><th></th><th>Logo</th><th>Nom</th><th>Actif</th><th></th></tr></thead>
<tbody data-reorder-body data-reorder-form="partenaires-reorder-form">
@forelse($partenaires as $p)
<tr data-id="{{ $p->id }}"><td><span class="reorder-handle"><i class="bi bi-grip-vertical"></i></span></td>
<td><img src="{{ $p->logo }}" alt="" height="40"></td>
<td>{{ $p->nom }}</td>
<td>{{ $p->actif ? 'Oui' : 'Non' }}</td>
<td class="text-end">
<a href="{{ route('admin.partenaires.edit', $p) }}" class="btn btn-sm btn-girona-outline"><i class="bi bi-pencil"></i></a>
<form action="{{ route('admin.partenaires.destroy', $p) }}" method="POST" class="d-inline">@csrf @method('DELETE')
<button type="button" class="btn btn-sm btn-outline-danger" data-admin-delete="Supprimer ?"><i class="bi bi-trash"></i></button></form>
</td></tr>
@empty
<tr><td colspan="5" class="admin-empty">Aucun partenaire.</td></tr>
@endforelse
</tbody></table>
<div class="mt-3">{{ $partenaires->links() }}</div>
</div></div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="{{ asset('js/reorder.js') }}?v=1"></script>
@endpush
