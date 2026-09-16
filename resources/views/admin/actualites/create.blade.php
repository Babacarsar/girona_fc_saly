@extends('layouts.admin')

@section('title', 'Nouvelle actualité')

@section('content')
<x-admin.page-header title="Publier une actualité" breadcrumb='<a href="'.route('admin.actualites.index').'">Actualités</a> / Création' />

<div class="admin-card">
    <div class="admin-card__body admin-form">
        <x-admin.validation-errors />
        <form action="{{ route('admin.actualites.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control form-control-lg" value="{{ old('titre') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contenu</label>
                <input type="hidden" name="contenu" id="contenu" value="{{ old('contenu') }}">
                <trix-editor input="contenu" class="rich-editor"></trix-editor>
            </div>
            @include('admin.partials.rich-editor')
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select" required>
                        <option value="draft" @selected(old('statut') === 'draft')>Brouillon</option>
                        <option value="published" @selected(old('statut', 'published') === 'published')>Publié</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Auteur</label>
                    <input type="text" name="auteur" class="form-control" value="{{ old('auteur') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date de publication</label>
                    <input type="date" name="date_publication" class="form-control" value="{{ old('date_publication') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="ordre" class="form-control" value="{{ old('ordre', 0) }}" min="0">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="a_la_une" value="1" id="a_la_une" @checked(old('a_la_une'))>
                        <label class="form-check-label" for="a_la_une">Mettre à la une</label>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Image de couverture</label>
                <div class="admin-upload-zone">
                    <input type="file" name="image" class="form-control" accept="image/*" data-image-preview="actuPreview">
                    <img id="actuPreview" class="admin-upload-preview mx-auto mt-3" alt="">
                </div>
            </div>
            <button type="submit" class="btn btn-girona">Publier</button>
            <a href="{{ route('admin.actualites.index') }}" class="btn btn-light">Annuler</a>
        </form>
    </div>
</div>
@endsection
