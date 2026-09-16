@extends('layouts.admin')

@section('title', 'Staff technique')

@section('content')
<x-admin.page-header title="Staff technique" description="Entraîneurs et encadrement par catégorie.">
    <x-slot:actions>
        <a href="{{ route('admin.staff.create') }}" class="btn btn-girona"><i class="bi bi-plus-lg me-1"></i> Ajouter</a>
    </x-slot:actions>
</x-admin.page-header>

<div class="admin-card">
    <div class="admin-card__body">
        <form method="GET" class="admin-toolbar">
            <div class="admin-search">
                <i class="bi bi-search"></i>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher…">
            </div>
            <select name="categorie_id" class="form-select" style="max-width: 220px" onchange="this.form.submit()">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($selectedCategorie == $cat->id)>{{ $cat->nom }}</option>
                @endforeach
            </select>
        </form>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Membre</th>
                        <th>Rôle</th>
                        <th>Catégorie</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $membre)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ admin_media_url($membre->photo, $membre->prenom.'+'.$membre->nom) }}" alt="" class="admin-avatar">
                                    <div class="fw-semibold">{{ $membre->prenom }} {{ $membre->nom }}</div>
                                </div>
                            </td>
                            <td>{{ $membre->role ?? '—' }}</td>
                            <td><span class="badge badge-girona">{{ $membre->categorie->nom ?? 'N/A' }}</span></td>
                            <td class="text-end">
                                <div class="admin-actions justify-content-end">
                                    <a href="{{ route('admin.staff.edit', $membre) }}" class="btn btn-sm btn-girona-outline"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.staff.destroy', $membre) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-admin-delete="Supprimer {{ $membre->prenom }} {{ $membre->nom }} ?"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4"><div class="admin-empty"><i class="bi bi-inbox"></i>Aucun membre.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
