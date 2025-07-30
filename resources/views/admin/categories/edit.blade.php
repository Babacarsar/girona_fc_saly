@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Modifier la catégorie</h2>

    <form action="{{ route('admin.categories.update', $categorie->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la catégorie</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ $categorie->nom }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
