@extends('layouts.admin')
@section('title', 'Partenaire')
@section('content')
<div class="admin-card col-lg-7"><div class="admin-card__body admin-form">
<x-admin.validation-errors />
<form method="POST" action="{{ route('admin.partenaires.store') }}" enctype="multipart/form-data">@csrf
<label class="form-label">Nom</label><input name="nom" class="form-control mb-3" value="{{ old('nom') }}" required>
<div class="mb-4 admin-upload-zone">
    <label class="form-label">Logo (fichier local)</label>
    <input type="file" name="logo" class="form-control" accept="image/*" data-image-preview="partenaireLogoPreview">
    <img id="partenaireLogoPreview" class="admin-upload-preview mx-auto mt-3" alt="">
    <p class="form-text text-muted mb-0">PNG, JPG ou WebP — max. 2 Mo.</p>
</div>
<label class="form-label">Ou URL du logo (Cloudinary / HTTPS)</label>
<input name="logo_url" type="url" class="form-control mb-3" value="{{ old('logo_url') }}" placeholder="https://…">
<label class="form-label">Site web</label><input name="url" type="url" class="form-control mb-3" value="{{ old('url') }}">
<label class="form-label">Description</label><input name="description" class="form-control mb-3" value="{{ old('description') }}">
<label class="form-label">Ordre</label><input name="ordre" type="number" class="form-control mb-3" min="0" value="{{ old('ordre') }}">
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="actif" value="1" checked id="actif"><label for="actif">Visible sur le site</label></div>
<button class="btn btn-girona">Enregistrer</button>
</form></div></div>
@endsection
