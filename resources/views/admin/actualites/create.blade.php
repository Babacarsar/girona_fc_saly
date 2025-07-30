@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>➕ Ajouter une actualité</h2>

    <form action="{{ route('admin.actualites.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Titre --}}
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" value="{{ old('titre') }}" required>
            @error('titre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Contenu --}}
        <div class="mb-3">
            <label class="form-label">Contenu</label>
            <textarea name="contenu" class="form-control" rows="5" required>{{ old('contenu') }}</textarea>
            @error('contenu') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label class="form-label">Image (optionnelle)</label>
            <input type="file" name="image" class="form-control">
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Boutons --}}
        <button type="submit" class="btn btn-success">💾 Enregistrer</button>
        <a href="{{ route('admin.actualites.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
