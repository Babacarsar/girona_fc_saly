@extends('layouts.admin')
@section('title', 'Partenaire')
@section('content')
<div class="admin-card col-lg-7"><div class="admin-card__body admin-form">
<x-admin.validation-errors />
<form method="POST" action="{{ route('admin.partenaires.update', $partenaire) }}" enctype="multipart/form-data">@csrf @method('PUT')
<label class="form-label">Nom</label><input name="nom" class="form-control mb-3" value="{{ old('nom', $partenaire->nom) }}" required>
<div class="mb-4 d-flex gap-4 flex-wrap align-items-start">
    <img src="{{ admin_media_url($partenaire->logo, $partenaire->nom) }}" alt="" class="admin-avatar admin-avatar--lg bg-white p-2">
    <div class="flex-grow-1 admin-upload-zone">
        <label class="form-label">Nouveau logo (fichier local)</label>
        <input type="file" name="logo" class="form-control" accept="image/*" data-image-preview="partenaireLogoEditPreview">
        <img id="partenaireLogoEditPreview" class="admin-upload-preview mt-3" alt="">
    </div>
</div>
<label class="form-label">Ou URL du logo</label>
<input name="logo_url" type="url" class="form-control mb-3" value="{{ old('logo_url', str_starts_with($partenaire->logo ?? '', 'http') ? $partenaire->logo : '') }}" placeholder="https://…">
<label class="form-label">Site</label><input name="url" type="url" class="form-control mb-3" value="{{ old('url', $partenaire->url) }}">
<label class="form-label">Description</label><input name="description" class="form-control mb-3" value="{{ old('description', $partenaire->description) }}">
<label class="form-label">Ordre</label><input name="ordre" type="number" class="form-control mb-3" value="{{ old('ordre', $partenaire->ordre) }}">
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="actif" value="1" id="actif" @checked(old('actif', $partenaire->actif))><label for="actif">Actif</label></div>
<button class="btn btn-girona">Mettre à jour</button>
</form></div></div>
@endsection
