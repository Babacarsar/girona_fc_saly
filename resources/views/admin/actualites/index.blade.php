@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>📰 Liste des actualités</h2>
        <a href="{{ route('admin.actualites.create') }}" class="btn btn-success">
            ➕ Ajouter une actualité
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Contenu</th>
                    <th>Date</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($actualites as $actu)
                    <tr>
                        <td class="text-center" style="width: 100px;">
                            @if ($actu->image)
                                <img src="{{ asset($actu->image) }}" alt="image" class="img-thumbnail rounded" width="80">
                            @else
                                <span class="text-muted">Aucune</span>
                            @endif
                        </td>
                        <td>{{ $actu->titre }}</td>
                        <td>{{ Str::limit(strip_tags($actu->contenu), 100, '...') }}</td>
                        <td>{{ $actu->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.actualites.edit', $actu->id) }}" class="btn btn-sm btn-primary">
                                    ✏️ Modifier
                                </a>
                                <form action="{{ route('admin.actualites.destroy', $actu->id) }}" method="POST" onsubmit="return confirm('Supprimer cette actualité ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Aucune actualité pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
