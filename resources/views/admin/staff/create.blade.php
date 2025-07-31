@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Ajouter un membre du staff technique</h2>

    <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rôle</label>
            <input type="text" name="role" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="categorie_id" class="form-select" required>
                <option value="">-- Choisir une catégorie --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
