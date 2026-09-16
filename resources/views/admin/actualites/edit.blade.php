@extends('layouts.admin')

@section('title', 'Modifier actualité')

@section('content')
<x-admin.page-header title="Modifier l’actualité" breadcrumb='<a href="'.route('admin.actualites.index').'">Actualités</a> / Édition' />

<div class="admin-card">
    <div class="admin-card__body admin-form">
        <form action="{{ route('admin.actualites.update', $actualite) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control form-control-lg" value="{{ old('titre', $actualite->titre) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contenu</label>
                <input type="hidden" name="contenu" id="contenu" value="{{ old('contenu', $actualite->contenu) }}">
                <trix-editor input="contenu" class="rich-editor"></trix-editor>
            </div>
            @include('admin.partials.rich-editor')
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Auteur</label>
                    <input type="text" name="auteur" class="form-control" value="{{ old('auteur', $actualite->auteur) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date de publication</label>
                    <input type="date" name="date_publication" class="form-control"
                           value="{{ old('date_publication', $actualite->date_publication ? \Carbon\Carbon::parse($actualite->date_publication)->format('Y-m-d') : '') }}">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Image</label>
                @if ($actualite->image)
                    <img src="{{ $actualite->image }}" alt="" class="rounded mb-3 d-block" style="max-width:200px">
                @endif
                <input type="file" name="image" class="form-control" accept="image/*" data-image-preview="actuEditPreview">
                <img id="actuEditPreview" class="admin-upload-preview mt-3" alt="">
            </div>
            <button type="submit" class="btn btn-girona">Mettre à jour</button>
            <a href="{{ route('admin.actualites.index') }}" class="btn btn-light">Annuler</a>
        </form>
    </div>
</div>
@endsection
