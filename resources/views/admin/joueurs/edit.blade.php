@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>✏️ Modifier le joueur</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.joueurs.update', $joueur->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nom et prénom --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="{{ old('nom', $joueur->nom) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $joueur->prenom) }}" required>
            </div>
        </div>

        {{-- Âge, Poste, Catégorie --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Âge</label>
                <input type="number" name="age" class="form-control" value="{{ old('age', $joueur->age) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Poste</label>
                <input type="text" name="poste" class="form-control" value="{{ old('poste', $joueur->poste) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Catégorie</label>
                <select name="categorie_id" class="form-select" required>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ old('categorie_id', $joueur->categorie_id) == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Photo --}}
        <div class="mb-3">
            <label class="form-label">Photo du joueur</label>
            <input type="file" name="photo" class="form-control">

            @if ($joueur->photo)
                <div class="mt-2">
                    <img src="{{ $joueur->photo }}" alt="Photo actuelle" width="100" style="border-radius: 6px;">
                    <p class="text-muted">Photo actuelle</p>
                </div>
            @endif
        </div>

        {{-- Boutons --}}
        <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
        <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
