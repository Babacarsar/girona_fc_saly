@extends('layouts.admin')

@section('title', 'Catégories')

@section('content')
<x-admin.page-header title="Catégories" description="U13, U15, Seniors… structurez l’académie.">
    <x-slot:actions>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-girona"><i class="bi bi-plus-lg me-1"></i> Nouvelle catégorie</a>
    </x-slot:actions>
</x-admin.page-header>

<div class="admin-card">
    <div class="admin-card__body p-0">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>#</th><th>Nom</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($categories as $categorie)
                        <tr>
                            <td><span class="text-muted">{{ $categorie->id }}</span></td>
                            <td class="fw-semibold">{{ $categorie->nom }}</td>
                            <td class="text-end">
                                <div class="admin-actions justify-content-end">
                                    <a href="{{ route('admin.categories.edit', $categorie) }}" class="btn btn-sm btn-girona-outline"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.categories.destroy', $categorie) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-admin-delete="Supprimer la catégorie « {{ $categorie->nom }} » ?"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3"><div class="admin-empty"><i class="bi bi-layers"></i>Aucune catégorie.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
