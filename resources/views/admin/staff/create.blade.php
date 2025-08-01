@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>➕ Ajouter un membre du staff technique</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nom --}}
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
        </div>

        {{-- Prénom --}}
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
        </div>

        {{-- Rôle (Poste) --}}
        <div class="mb-3">
            <label class="form-label">Rôle</label>
            <input type="text" name="role" class="form-control" value="{{ old('role') }}" required>
        </div>

        {{-- Catégorie --}}
        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="categorie_id" class="form-select" required>
                <option value="">-- Choisir une catégorie --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Photo --}}
        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        {{-- Boutons --}}
        <button type="submit" class="btn btn-success">💾 Enregistrer</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
