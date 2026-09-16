@extends('layouts.admin')
@section('title', 'Pré-inscriptions')
@section('content')
<x-admin.page-header title="Pré-inscriptions">
    <x-slot:actions>
        <a href="{{ route('admin.pre_inscriptions.export') }}" class="btn btn-girona-outline"><i class="bi bi-download"></i> Export CSV</a>
    </x-slot:actions>
</x-admin.page-header>
<form method="GET" class="mb-3">
<label class="form-check-label"><input type="checkbox" name="non_traite" value="1" @checked(request('non_traite')) onchange="this.form.submit()"> Non traitées uniquement</label>
</form>
<div class="admin-card"><div class="admin-card__body p-0">
<table class="admin-table"><thead><tr>
<th>Enfant</th><th>Naissance</th><th>Catégorie</th><th>Contact</th><th>Date</th><th>Traité</th>
</tr></thead><tbody>
@forelse($inscriptions as $i)
<tr>
<td>{{ $i->prenom }} {{ $i->nom }}</td>
<td>{{ $i->date_naissance->format('d/m/Y') }}</td>
<td>{{ $i->categorie->nom ?? '—' }}</td>
<td>{{ $i->email_parent }}<br><small>{{ $i->telephone }}</small></td>
<td>{{ $i->created_at->format('d/m/Y H:i') }}</td>
<td>
<form method="POST" action="{{ route('admin.pre_inscriptions.toggle', $i) }}">@csrf @method('PATCH')
<button class="btn btn-sm {{ $i->traite ? 'btn-success' : 'btn-outline-secondary' }}">{{ $i->traite ? 'Traité' : 'À traiter' }}</button>
</form>
</td></tr>
@empty<tr><td colspan="6" class="admin-empty">Aucune demande.</td></tr>@endforelse
</tbody></table>
<div class="p-3">{{ $inscriptions->links() }}</div>
</div></div>
@endsection
