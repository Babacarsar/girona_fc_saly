@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Modifier un média</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.media.update', $media->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Titre (facultatif) --}}
        <div class="mb-3">
            <label class="form-label">Titre <small class="text-muted">(facultatif)</small></label>
            <input type="text" name="titre" value="{{ old('titre', $media->titre) }}" class="form-control" placeholder="Titre du média">
        </div>

        {{-- Type --}}
        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" id="type_input" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                <option value="image" {{ $media->type === 'image' ? 'selected' : '' }}>Image</option>
                <option value="video" {{ $media->type === 'video' ? 'selected' : '' }}>Vidéo</option>
            </select>
        </div>

        {{-- URL Cloudinary --}}
        <div class="mb-3">
            <label class="form-label">Fichier (Cloudinary)</label>
            <div class="input-group">
                <input type="text" name="url" id="url_input" class="form-control" value="{{ old('url', $media->url) }}" required>
                <button type="button" class="btn btn-outline-primary" id="upload_widget_btn">Uploader</button>
            </div>
            <small class="text-muted">Si tu réuploades un fichier, l’URL et le type seront mis à jour automatiquement.</small>
        </div>

        {{-- Aperçu --}}
        <div class="mb-4">
            @if ($media->type === 'image')
                <img src="{{ $media->url }}" alt="Image actuelle" class="img-thumbnail" style="max-width: 300px;">
            @elseif ($media->type === 'video')
                <video width="320" height="240" controls>
                    <source src="{{ $media->url }}">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

{{-- Cloudinary Widget --}}
<script src="https://widget.cloudinary.com/v2.0/global/all.js"></script>
<script>
  const widget = cloudinary.createUploadWidget({
    cloudName: 'df2jerxfy',
    uploadPreset: 'girona_unsigned', // ⬅ Ton preset Cloudinary NON signé
    folder: 'media_girona',
    multiple: false,
    resourceType: 'auto'
  }, (error, result) => {
    if (!error && result && result.event === "success") {
      document.getElementById("url_input").value = result.info.secure_url;
      document.getElementById("type_input").value = result.info.resource_type;
    } else if (error) {
      alert("Erreur lors de l'upload : " + error.message);
    }
  });

  document.getElementById("upload_widget_btn").addEventListener("click", function () {
    widget.open();
  }, false);
</script>
@endsection
