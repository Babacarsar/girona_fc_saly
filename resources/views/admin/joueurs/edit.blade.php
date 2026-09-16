@extends('layouts.admin')

@section('title', 'Modifier joueur')

@section('content')
<x-admin.page-header
    title="Modifier {{ $joueur->prenom }} {{ $joueur->nom }}"
    breadcrumb='<a href="'.route('admin.joueurs.index').'">Joueurs</a> / Édition'
/>

<div class="admin-card">
    <div class="admin-card__body admin-form">
        <x-admin.validation-errors />

        <form action="{{ route('admin.joueurs.update', $joueur) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom', $joueur->nom) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $joueur->prenom) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Poste</label>
                    <input type="text" name="poste" class="form-control" value="{{ old('poste', $joueur->poste) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie_id" class="form-select" required>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" @selected(old('categorie_id', $joueur->categorie_id) == $categorie->id)>{{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Photo</label>
                <div class="d-flex align-items-start gap-4 flex-wrap">
                    <img src="{{ admin_media_url($joueur->photo, $joueur->prenom.'+'.$joueur->nom) }}" alt="" class="admin-avatar admin-avatar--lg">
                    <div class="flex-grow-1 admin-upload-zone">
                        <input type="file" name="photo" class="form-control" accept="image/*" data-image-preview="photoPreviewEdit">
                        <img id="photoPreviewEdit" class="admin-upload-preview mt-3" alt="Aperçu">
                        <small class="text-muted d-block mt-2">Laisser vide pour conserver la photo actuelle.</small>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-girona">Mettre à jour</button>
                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-light">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
