@extends('layouts.admin')

@section('title', 'Nouveau joueur')

@section('content')
<x-admin.page-header
    title="Nouveau joueur"
    description="Ajoutez un membre de l’effectif avec photo et catégorie."
    breadcrumb='<a href="'.route('admin.joueurs.index').'">Joueurs</a> / Création'
/>

<div class="admin-card">
    <div class="admin-card__body admin-form">
        <x-admin.validation-errors />

        <form action="{{ route('admin.joueurs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Âge</label>
                    <input type="number" name="age" class="form-control" value="{{ old('age') }}" min="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Poste</label>
                    <input type="text" name="poste" class="form-control" value="{{ old('poste') }}" placeholder="Ex. Attaquant">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie_id" class="form-select" required>
                        <option value="">Choisir…</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" @selected(old('categorie_id') == $categorie->id)>{{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Photo</label>
                <div class="admin-upload-zone">
                    <i class="bi bi-cloud-arrow-up fs-2 text-danger mb-2 d-block"></i>
                    <input type="file" name="photo" class="form-control" accept="image/*" data-image-preview="photoPreview">
                    <img id="photoPreview" class="admin-upload-preview mx-auto mt-3" alt="Aperçu">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-girona"><i class="bi bi-check-lg me-1"></i> Enregistrer</button>
                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-light">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
