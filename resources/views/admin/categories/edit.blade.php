@extends('layouts.admin')

@section('title', 'Modifier catégorie')

@section('content')
<x-admin.page-header title="Modifier « {{ $categorie->nom }} »" breadcrumb='<a href="'.route('admin.categories.index').'">Catégories</a> / Édition' />

<div class="admin-card col-lg-6">
    <div class="admin-card__body admin-form">
        <form action="{{ route('admin.categories.update', $categorie) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control form-control-lg" value="{{ old('nom', $categorie->nom) }}" required>
            </div>
            <button type="submit" class="btn btn-girona">Mettre à jour</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Annuler</a>
        </form>
    </div>
</div>
@endsection
