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

        {{-- Image --}}
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror

            @if ($actualite->image)
                <div class="mt-2">
                    <img src="{{ asset($actualite->image) }}" alt="Image actuelle" width="150" class="img-thumbnail">
                    <p class="text-muted mb-0">Image actuelle</p>
                </div>
            @endif
        </div>

        {{-- Boutons --}}
        <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
        <a href="{{ route('admin.actualites.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
