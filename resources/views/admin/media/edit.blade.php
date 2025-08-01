@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Modifier un média</h2>

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
            <select name="type" class="form-select" required>
                <option value="image" {{ $media->type === 'image' ? 'selected' : '' }}>Image</option>
                <option value="video" {{ $media->type === 'video' ? 'selected' : '' }}>Vidéo</option>
            </select>
        </div>

        {{-- URL (Cloudinary) --}}
        <div class="mb-3">
            <label class="form-label">URL Cloudinary</label>
            <div class="input-group">
                <input type="text" name="url" id="url_input" value="{{ old('url', $media->url) }}" class="form-control" required>
                <button type="button" class="btn btn-outline-primary" id="upload_widget_btn">Changer le fichier</button>
            </div>
            @if ($media->type === 'image')
                <div class="mt-3">
                    <img src="{{ $media->url }}" alt="image actuelle" class="img-thumbnail" style="max-width: 200px;">
                </div>
            @elseif ($media->type === 'video')
                <div class="mt-3">
                    <video width="320" height="180" controls>
                        <source src="{{ $media->url }}">
                        Votre navigateur ne supporte pas la vidéo.
                    </video>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

{{-- Cloudinary Upload Widget --}}
<script src="https://widget.cloudinary.com/v2.0/global/all.js"></script>
<script>
  const widget = cloudinary.createUploadWidget({
    cloudName: 'df2jerxfy',
    uploadPreset: 'default_preset', // Remplace par le tien
    multiple: false
  }, (error, result) => {
    if (!error && result && result.event === "success") {
      document.getElementById("url_input").value = result.info.secure_url;
    }
  });

  document.getElementById("upload_widget_btn").addEventListener("click", function () {
    widget.open();
  }, false);
</script>
@endsection
