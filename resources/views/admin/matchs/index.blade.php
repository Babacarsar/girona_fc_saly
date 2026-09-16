@extends('layouts.admin')
@section('title', 'Calendrier')
@section('content')
<x-admin.page-header title="Matchs & résultats">
    <x-slot:actions><a href="{{ route('admin.matchs.create') }}" class="btn btn-girona"><i class="bi bi-plus-lg"></i> Ajouter</a></x-slot:actions>
</x-admin.page-header>
<div class="admin-card"><div class="admin-card__body p-0">
<table class="admin-table"><thead><tr>
<th>Date</th><th>Adversaire</th><th>Score</th><th>Type</th><th>Catégorie</th><th></th>
</tr></thead><tbody>
@forelse($matchs as $m)
<tr>
<td>{{ $m->date_match->format('d/m/Y H:i') }}</td>
<td>{{ $m->adversaire }} @if($m->lieu)<small class="text-muted d-block">{{ $m->lieu }}</small>@endif</td>
<td>{{ $m->score_domicile && $m->score_exterieur ? $m->score_domicile.' - '.$m->score_exterieur : '—' }}</td>
<td>{{ ucfirst($m->type) }}</td>
<td>{{ $m->categorie->nom ?? '—' }}</td>
<td class="text-end">
<a href="{{ route('admin.matchs.edit', $m) }}" class="btn btn-sm btn-girona-outline"><i class="bi bi-pencil"></i></a>
<form action="{{ route('admin.matchs.destroy', $m) }}" method="POST" class="d-inline">@csrf @method('DELETE')
<button type="button" class="btn btn-sm btn-outline-danger" data-admin-delete="Supprimer ?"><i class="bi bi-trash"></i></button></form>
</td></tr>
@empty<tr><td colspan="6" class="admin-empty">Aucun match.</td></tr>@endforelse
</tbody></table>
<div class="p-3">{{ $matchs->links() }}</div>
</div></div>
@endsection
