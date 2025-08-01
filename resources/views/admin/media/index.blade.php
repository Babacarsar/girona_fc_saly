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

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Aperçu</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($media as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->titre ?? '---' }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst($item->type) }}</span>
                        </td>
                        <td>
                            @if ($item->type === 'image')
                                <img src="{{ $item->url }}" alt="Image" class="img-thumbnail" style="max-width: 120px;">
                            @elseif ($item->type === 'video')
                                <video width="160" height="100" controls>
                                    <source src="{{ $item->url }}">
                                    Votre navigateur ne supporte pas la vidéo.
                                </video>
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.media.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Modifier</a>

                                <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Aucun média trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $media->links() }}
    </div>
</div>
@endsection
