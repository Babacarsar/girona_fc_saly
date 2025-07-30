@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4 fw-semibold text-dark">🧢 Liste du Staff Technique</h2>

    {{-- Bouton ajout --}}
    <div class="mb-3">
        <a href="{{ route('admin.staff.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Ajouter un membre
        </a>
    </div>

    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filtre par catégorie --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="categorie_id" class="form-label">📁 Filtrer par catégorie :</label>
                        <select name="categorie_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Toutes les catégories --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $selectedCategorie == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Photo</th>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Rôle</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $membre)
                        <tr>
                            <td class="text-center">
                                @if ($membre->photo)
                                    <img src="{{ asset($membre->photo) }}" alt="Photo" width="60" height="60"
                                         style="object-fit: cover; border-radius: 50%;">
                                @else
                                    <span class="text-muted">Aucune</span>
                                @endif
                            </td>
                            <td>{{ $membre->id }}</td>
                            <td>{{ $membre->nom }}</td>
                            <td>{{ $membre->prenom }}</td>
                            <td>{{ $membre->role }}</td>
                            <td>{{ $membre->categorie->nom ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.staff.edit', $membre->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.staff.destroy', $membre->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce membre ?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Aucun membre trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
