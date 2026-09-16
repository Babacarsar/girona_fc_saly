@extends('layouts.admin')

@section('title', 'Nouvelle catégorie')

@section('content')
<x-admin.page-header title="Nouvelle catégorie" breadcrumb='<a href="'.route('admin.categories.index').'">Catégories</a> / Création' />

<div class="admin-card col-lg-6">
    <div class="admin-card__body admin-form">
        <x-admin.validation-errors />
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nom" class="form-label">Nom de la catégorie</label>
                <input type="text" name="nom" id="nom" class="form-control form-control-lg" value="{{ old('nom') }}" placeholder="Ex. U17, Seniors…" required>
            </div>
            <button type="submit" class="btn btn-girona">Enregistrer</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Annuler</a>
        </form>
    </div>
</div>
@endsection
