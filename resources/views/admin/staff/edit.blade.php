@extends('layouts.admin')

@section('title', 'Modifier staff')

@section('content')
<x-admin.page-header title="Modifier {{ $staff->prenom }} {{ $staff->nom }}" breadcrumb='<a href="'.route('admin.staff.index').'">Staff</a> / Édition' />

<div class="admin-card">
    <div class="admin-card__body admin-form">
        <x-admin.validation-errors />
        <form action="{{ route('admin.staff.update', $staff) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3 mb-3">
                <div class="col-md-6"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" value="{{ old('nom', $staff->nom) }}" required></div>
                <div class="col-md-6"><label class="form-label">Prénom</label><input type="text" name="prenom" class="form-control" value="{{ old('prenom', $staff->prenom) }}" required></div>
                <div class="col-md-6"><label class="form-label">Rôle</label><input type="text" name="role" class="form-control" value="{{ old('role', $staff->role) }}" required></div>
                <div class="col-md-6">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie_id" class="form-select" required>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" @selected(old('categorie_id', $staff->categorie_id) == $categorie->id)>{{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4 d-flex gap-4 flex-wrap align-items-start">
                <img src="{{ admin_media_url($staff->photo, $staff->prenom.'+'.$staff->nom) }}" alt="" class="admin-avatar admin-avatar--lg">
                <div class="flex-grow-1 admin-upload-zone">
                    <input type="file" name="photo" class="form-control" accept="image/*" data-image-preview="staffEditPreview">
                    <img id="staffEditPreview" class="admin-upload-preview mt-3" alt="">
                </div>
            </div>
            <button type="submit" class="btn btn-girona">Mettre à jour</button>
            <a href="{{ route('admin.staff.index') }}" class="btn btn-light">Annuler</a>
        </form>
    </div>
</div>
@endsection
