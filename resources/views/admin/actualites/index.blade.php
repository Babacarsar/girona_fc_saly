@extends('layouts.admin')

@section('title', 'Actualités')

@section('content')
<x-admin.page-header title="Actualités" description="Articles et annonces publiés sur le site.">
    <x-slot:actions>
        <a href="{{ route('admin.actualites.create') }}" class="btn btn-girona"><i class="bi bi-plus-lg me-1"></i> Publier</a>
    </x-slot:actions>
</x-admin.page-header>

<div class="admin-card">
    <div class="admin-card__body p-0">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Extrait</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($actualites as $actu)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($actu->image)
                                        <img src="{{ $actu->image }}" alt="" class="rounded" width="56" height="56" style="object-fit:cover">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:56px;height:56px"><i class="bi bi-image text-muted"></i></div>
                                    @endif
                                    <div class="fw-semibold">{{ $actu->titre }}</div>
                                </div>
                            </td>
                            <td class="text-muted small">{{ Str::limit(strip_tags($actu->contenu), 80) }}</td>
                            <td>{{ $actu->date_publication ? \Carbon\Carbon::parse($actu->date_publication)->format('d/m/Y') : $actu->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <div class="admin-actions justify-content-end">
                                    <a href="{{ route('admin.actualites.edit', $actu) }}" class="btn btn-sm btn-girona-outline"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.actualites.destroy', $actu) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-admin-delete="Supprimer « {{ $actu->titre }} » ?"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4"><div class="admin-empty"><i class="bi bi-newspaper"></i>Aucune actualité.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
