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
                <textarea name="contenu" class="form-control" rows="8" required placeholder="Rédigez votre article…">{{ old('contenu') }}</textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Auteur</label>
                    <input type="text" name="auteur" class="form-control" value="{{ old('auteur') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date de publication</label>
                    <input type="date" name="date_publication" class="form-control" value="{{ old('date_publication') }}">
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
