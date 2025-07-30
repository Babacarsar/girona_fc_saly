@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>📁 Liste des catégories</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
            ➕ Ajouter une catégorie
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Nom</th>
                    <th style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $categorie)
                    <tr>
                        <td>{{ $categorie->id }}</td>
                        <td>{{ $categorie->nom }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.categories.edit', $categorie->id) }}" class="btn btn-sm btn-primary">
                                    ✏️ Modifier
                                </a>
                                <form action="{{ route('admin.categories.destroy', $categorie->id) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Aucune catégorie trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
