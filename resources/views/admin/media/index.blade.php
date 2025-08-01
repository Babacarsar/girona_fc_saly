@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>🎥 Liste des médias</h2>
        <a href="{{ route('admin.media.create') }}" class="btn btn-primary">➕ Ajouter un média</a>
    </div>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tableau --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Prévisualisation</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($media as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title ?? '—' }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst($item->type) }}</span>
                        </td>
                        <td>
                            @if($item->type === 'image')
                                <img src="{{ $item->file_path }}" alt="image" class="img-thumbnail" style="max-width: 120px;">
                            @elseif($item->type === 'video')
                                <video width="160" height="100" controls>
                                    <source src="{{ $item->file_path }}" type="video/mp4">
                                    Votre navigateur ne supporte pas la vidéo.
                                </video>
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑️ Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">Aucun média trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
