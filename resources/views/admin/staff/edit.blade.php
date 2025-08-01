@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>✏️ Modifier le membre du staff</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nom --}}
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $staff->nom) }}" required>
        </div>

        {{-- Prénom --}}
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $staff->prenom) }}" required>
        </div>

        {{-- Poste --}}
        <div class="mb-3">
            <label class="form-label">Rôle</label>
            <input type="text" name="role" class="form-control" value="{{ old('role', $staff->role) }}" required>
        </div>

        {{-- Catégorie --}}
        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="categorie_id" class="form-select" required>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('categorie_id', $staff->categorie_id) == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Photo --}}
        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">

            @if($staff->photo)
                <div class="mt-2">
                    <img src="{{ $staff->photo }}" alt="Photo actuelle" width="100" class="rounded border">
                    <p class="text-muted mb-0">Photo actuelle</p>
                </div>
            @endif
        </div>

        {{-- Boutons --}}
        <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
