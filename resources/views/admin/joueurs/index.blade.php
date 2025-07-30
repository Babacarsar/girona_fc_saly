@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Liste des Joueurs</h2>

    <a href="{{ route('admin.joueurs.create') }}" class="btn btn-success mb-3">➕ Ajouter un joueur</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filtre par catégorie --}}
    <form method="GET" class="mb-4">
        <div class="row align-items-end">
            <div class="col-md-4">
                <label for="categorie_id" class="form-label">Filtrer par catégorie :</label>
                <select name="categorie_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Toutes les catégories --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $selectedCategorie == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    {{-- Tableau --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Photo</th>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Poste</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($joueurs as $joueur)
                    <tr>
                        <td class="text-center">
                            @if ($joueur->photo)
                                <img src="{{ asset($joueur->photo) }}" alt="Photo" width="60" height="60" class="rounded-circle object-fit-cover">
                            @else
                                <span class="text-muted">Aucune</span>
                            @endif
                        </td>
                        <td>{{ $joueur->id }}</td>
                        <td>{{ $joueur->nom }}</td>
                        <td>{{ $joueur->prenom }}</td>
                        <td>{{ $joueur->poste }}</td>
                        <td>{{ $joueur->categorie->nom ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.joueurs.edit', $joueur->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                                <form action="{{ route('admin.joueurs.destroy', $joueur->id) }}" method="POST" onsubmit="return confirm('Supprimer ce joueur ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Aucun joueur trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
