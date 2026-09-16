@extends('layouts.admin')

@section('title', 'Nouveau staff')

@section('content')
<x-admin.page-header title="Nouveau membre du staff" breadcrumb='<a href="'.route('admin.staff.index').'">Staff</a> / Création' />

<div class="admin-card">
    <div class="admin-card__body admin-form">
        <x-admin.validation-errors />
        <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-md-6"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required></div>
                <div class="col-md-6"><label class="form-label">Prénom</label><input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required></div>
                <div class="col-md-6"><label class="form-label">Rôle</label><input type="text" name="role" class="form-control" value="{{ old('role') }}" required placeholder="Entraîneur, adjoint…"></div>
                <div class="col-md-6">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie_id" class="form-select" required>
                        <option value="">Choisir…</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" @selected(old('categorie_id') == $categorie->id)>{{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Photo</label>
                <div class="admin-upload-zone">
                    <input type="file" name="photo" class="form-control" accept="image/*" data-image-preview="staffPreview">
                    <img id="staffPreview" class="admin-upload-preview mx-auto mt-3" alt="">
                </div>
            </div>
            <button type="submit" class="btn btn-girona">Enregistrer</button>
            <a href="{{ route('admin.staff.index') }}" class="btn btn-light">Annuler</a>
        </form>
    </div>
</div>
@endsection
