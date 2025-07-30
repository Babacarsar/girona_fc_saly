@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Modifier le joueur</h2>

    <form action="{{ route('admin.joueurs.update', $joueur->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ $joueur->nom }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ $joueur->prenom }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Âge</label>
            <input type="number" name="age" class="form-control" value="{{ $joueur->age }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Poste</label>
            <input type="text" name="poste" class="form-control" value="{{ $joueur->poste }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="categorie_id" class="form-select" required>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ $categorie->id == $joueur->categorie_id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Ajout du champ image --}}
        <div class="mb-3">
            <label class="form-label">Photo du joueur</label>
            <input type="file" name="photo" class="form-control">

            @if ($joueur->photo)
                <div class="mt-2">
                    <img src="{{ asset($joueur->photo) }}" alt="Photo actuelle" width="100" style="border-radius: 6px;">
                    <p class="text-muted">Photo actuelle</p>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
