@extends('layouts.admin')

@section('title', 'Photos — sélection')

@section('content')
<x-admin.page-header
    title="Photos des joueurs"
    description="Ajoutez ou remplacez les photos pour la sélection ({{ $joueurs->count() }} joueur(s))."
    breadcrumb='<a href="'.route('admin.joueurs.index', $listQuery).'">Joueurs</a> / Photos'
/>

<div class="admin-card">
    <div class="admin-card__body admin-form">
        @error('photos')
            <div class="alert alert-danger py-2">{{ $message }}</div>
        @enderror

        <form action="{{ route('admin.joueurs.bulk_photos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @foreach($listQuery as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            @foreach($joueurs as $joueur)
                <input type="hidden" name="ids[]" value="{{ $joueur->id }}">
            @endforeach

            <div class="row g-4 mb-4">
                @foreach($joueurs as $joueur)
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="border rounded-3 p-3 h-100 bg-white shadow-sm">
                            <div class="text-center mb-3">
                                <img
                                    id="bulk-photo-preview-{{ $joueur->id }}"
                                    src="{{ admin_media_url($joueur->photo, $joueur->prenom.'+'.$joueur->nom) }}"
                                    alt=""
                                    class="rounded admin-avatar admin-avatar--lg mx-auto d-block mb-2"
                                    style="width:120px;height:120px;object-fit:cover"
                                >
                                <h3 class="h6 fw-bold mb-0">{{ $joueur->prenom }} {{ $joueur->nom }}</h3>
                                <p class="small text-muted mb-0">{{ $joueur->poste ?? '—' }} · {{ $joueur->categorie->nom ?? '' }}</p>
                            </div>
                            <label class="form-label small fw-semibold" for="photo-{{ $joueur->id }}">Nouvelle photo</label>
                            <input
                                type="file"
                                name="photos[{{ $joueur->id }}]"
                                id="photo-{{ $joueur->id }}"
                                class="form-control form-control-sm"
                                accept="image/*"
                                data-bulk-photo-preview="bulk-photo-preview-{{ $joueur->id }}"
                            >
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-girona">
                    <i class="bi bi-check-lg me-1"></i> Enregistrer les photos
                </button>
                <a href="{{ route('admin.joueurs.index', $listQuery) }}" class="btn btn-light">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
  document.querySelectorAll('[data-bulk-photo-preview]').forEach((input) => {
    const previewId = input.getAttribute('data-bulk-photo-preview');
    const preview = previewId ? document.getElementById(previewId) : null;
    input.addEventListener('change', () => {
      const file = input.files?.[0];
      if (!file || !preview) return;
      preview.src = URL.createObjectURL(file);
    });
  });
})();
</script>
@endpush
