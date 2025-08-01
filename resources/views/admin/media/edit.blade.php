@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Modifier un média</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire --}}
    <form action="{{ route('admin.media.update', $media->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Titre --}}
        <div class="mb-3">
            <label class="form-label">Titre <small class="text-muted">(facultatif)</small></label>
            <input type="text" name="title" value="{{ old('title', $media->title) }}" class="form-control" placeholder="Titre du média">
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
            <label class="form-label">URL du fichier (Cloudinary)</label>
            <input type="url" name="url" value="{{ old('url', $media->file_path) }}" class="form-control" required>
            <small class="text-muted">Ex : https://res.cloudinary.com/toncloud/image/upload/v... </small>
        </div>

        {{-- Aperçu --}}
        <div class="mb-4">
            @if($media->type === 'image')
                <img src="{{ $media->file_path }}" alt="Aperçu" class="img-thumbnail" style="max-width: 200px;">
            @elseif($media->type === 'video')
                <video width="300" controls>
                    <source src="{{ $media->file_path }}" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
