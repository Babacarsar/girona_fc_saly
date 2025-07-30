@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Ajouter un nouveau média</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Titre (optionnel)</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" class="form-select" required>
                <option value="">-- Choisir --</option>
                <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>Image</option>
                <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Vidéo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Fichier</label>
            <input type="file" name="file" class="form-control" accept="image/*,video/*" required>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
