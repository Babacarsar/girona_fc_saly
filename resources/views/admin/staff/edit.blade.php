@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Modifier le membre du staff</h2>

    <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ $staff->nom }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ $staff->prenom }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rôle</label>
            <input type="text" name="role" class="form-control" value="{{ $staff->role }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="categorie_id" class="form-select" required>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ $categorie->id == $staff->categorie_id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
            @if($staff->photo)
                <div class="mt-2">
                    <img src="{{ asset($staff->photo) }}" alt="Photo actuelle" width="100">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
