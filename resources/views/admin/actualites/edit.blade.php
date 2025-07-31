@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>✏️ Modifier une actualité</h2>

    <form action="{{ route('admin.actualites.update', $actualite->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Titre --}}
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" value="{{ old('titre', $actualite->titre) }}" required>
            @error('titre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Contenu --}}
        <div class="mb-3">
            <label class="form-label">Contenu</label>
            <textarea name="contenu" class="form-control" rows="5" required>{{ old('contenu', $actualite->contenu) }}</textarea>
            @error('contenu') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Auteur --}}
        <div class="mb-3">
            <label class="form-label">Auteur (optionnel)</label>
            <input type="text" name="auteur" class="form-control" value="{{ old('auteur', $actualite->auteur) }}">
            @error('auteur') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Date de publication --}}
        <div class="mb-3">
            <label class="form-label">Date de publication (optionnelle)</label>
            <input type="date" name="date_publication" class="form-control"
                   value="{{ old('date_publication', $actualite->date_publication ? $actualite->date_publication->format('Y-m-d') : '') }}">
            @error('date_publication') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label class="form-label">Nouvelle image (optionnelle)</label>
            <input type="file" name="image" class="form-control">
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror

            @if ($actualite->image)
                <div class="mt-3">
                    <img src="{{ $actualite->image }}" alt="Image actuelle" width="150" class="img-thumbnail">
                    <p class="text-muted mb-0">Image actuelle (Cloudinary)</p>
                </div>
            @endif
        </div>

        {{-- Boutons --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
            <a href="{{ route('admin.actualites.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
