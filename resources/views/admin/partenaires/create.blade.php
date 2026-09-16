@extends('layouts.admin')
@section('title', 'Partenaire')
@section('content')
<div class="admin-card col-lg-7"><div class="admin-card__body admin-form">
<form method="POST" action="{{ route('admin.partenaires.store') }}">@csrf
<label class="form-label">Nom</label><input name="nom" class="form-control mb-3" required>
<label class="form-label">URL du logo (Cloudinary ou HTTPS)</label><input name="logo" type="url" class="form-control mb-3" required>
<label class="form-label">Site web</label><input name="url" type="url" class="form-control mb-3">
<label class="form-label">Description</label><input name="description" class="form-control mb-3">
<label class="form-label">Ordre</label><input name="ordre" type="number" class="form-control mb-3" min="0">
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="actif" value="1" checked id="actif"><label for="actif">Visible sur le site</label></div>
<button class="btn btn-girona">Enregistrer</button>
</form></div></div>
@endsection
