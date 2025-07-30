@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Ajouter un joueur</h2>

    <form action="{{ route('admin.joueurs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Âge</label>
                <input type="number" name="age" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Poste</label>
                <input type="text" name="poste" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Catégorie</label>
                <select name="categorie_id" class="form-select" required>
                    <option value="">-- Choisir une catégorie --</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo du joueur</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
