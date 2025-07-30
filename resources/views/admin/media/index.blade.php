@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des médias</h2>
        <a href="{{ route('admin.media.create') }}" class="btn btn-primary">Ajouter un média</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Type</th>
                <th>Fichier</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($media as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title ?? '---' }}</td>
                    <td>{{ ucfirst($item->type) }}</td>
                    <td>
                        @if($item->type === 'image')
                            <img src="{{ asset('storage/' . $item->path) }}" alt="image" width="100">
                        @else
                            <video width="150" controls>
                                <source src="{{ asset('storage/' . $item->path) }}">
                                Votre navigateur ne supporte pas la lecture vidéo.
                            </video>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                        <form action="{{ route('admin.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Supprimer ce média ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Aucun média trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection