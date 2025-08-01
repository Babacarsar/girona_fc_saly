@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Modifier un média</h2>

    <form action="{{ route('admin.media.update', $media->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Titre (facultatif) --}}
        <div class="mb-3">
            <label class="form-label">Titre <small class="text-muted">(facultatif)</small></label>
            <input type="text" name="titre" value="{{ old('titre', $media->titre) }}" class="form-control" placeholder="Titre du média">
        </div>

        {{-- Type --}}
        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select" required>
                <option value="image" {{ $media->type === 'image' ? 'selected' : '' }}>Image</option>
                <option value="video" {{ $media->type === 'video' ? 'selected' : '' }}>Vidéo</option>
            </select>
        </div>

        {{-- URL Cloudinary --}}
        <div class="mb-3">
            <label class="form-label">URL Cloudinary</label>
            <input type="text" name="url" value="{{ old('url', $media->url) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
