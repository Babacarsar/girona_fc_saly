@extends('layouts.admin')

@section('title', 'Médias')

@section('content')
<x-admin.page-header title="Galerie médias" description="Photos et vidéos hébergées sur Cloudinary.">
    <x-slot:actions>
        <a href="{{ route('admin.media.create') }}" class="btn btn-girona"><i class="bi bi-cloud-upload me-1"></i> Ajouter</a>
    </x-slot:actions>
</x-admin.page-header>

@if($media->count())
    <div class="row g-4">
        @foreach($media as $item)
            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="admin-card h-100">
                    <div class="ratio ratio-16x9 bg-light">
                        @if ($item->type === 'image')
                            <img src="{{ $item->file_path }}" alt="" class="object-fit-cover rounded-top" style="object-fit:cover;width:100%;height:100%">
                        @else
                            <video class="w-100 h-100" controls preload="metadata">
                                <source src="{{ $item->file_path }}" type="video/mp4">
                            </video>
                        @endif
                    </div>
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <div class="fw-semibold text-truncate">{{ $item->title ?: 'Sans titre' }}</div>
                            <span class="badge badge-girona">{{ ucfirst($item->type) }}</span>
                        </div>
                        <small class="text-muted d-block mb-3">{{ $item->created_at->format('d/m/Y H:i') }}</small>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.media.edit', $item) }}" class="btn btn-sm btn-girona-outline flex-grow-1">Modifier</a>
                            <form action="{{ route('admin.media.destroy', $item) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger" data-admin-delete="Supprimer ce média ?"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {{ $media->links() }}
    </div>
@else
    <div class="admin-card">
        <div class="admin-empty py-5">
            <i class="bi bi-camera-reels"></i>
            Aucun média. <a href="{{ route('admin.media.create') }}">Importer le premier fichier</a>
        </div>
    </div>
@endif
@endsection
