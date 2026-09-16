@extends('layouts.admin')
@section('title', 'Partenaire')
@section('content')
<div class="admin-card col-lg-7"><div class="admin-card__body admin-form">
<form method="POST" action="{{ route('admin.partenaires.update', $partenaire) }}">@csrf @method('PUT')
<label class="form-label">Nom</label><input name="nom" class="form-control mb-3" value="{{ old('nom', $partenaire->nom) }}" required>
<label class="form-label">Logo URL</label><input name="logo" type="url" class="form-control mb-3" value="{{ old('logo', $partenaire->logo) }}" required>
<label class="form-label">Site</label><input name="url" type="url" class="form-control mb-3" value="{{ old('url', $partenaire->url) }}">
<label class="form-label">Description</label><input name="description" class="form-control mb-3" value="{{ old('description', $partenaire->description) }}">
<label class="form-label">Ordre</label><input name="ordre" type="number" class="form-control mb-3" value="{{ old('ordre', $partenaire->ordre) }}">
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="actif" value="1" id="actif" @checked(old('actif', $partenaire->actif))><label for="actif">Actif</label></div>
<button class="btn btn-girona">Mettre à jour</button>
</form></div></div>
@endsection
