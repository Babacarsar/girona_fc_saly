@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Ajouter un média</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.media.store') }}" method="POST">
        @csrf

        {{-- Titre --}}
        <div class="mb-3">
            <label class="form-label">Titre (facultatif)</label>
            <input type="text" name="titre" class="form-control" placeholder="Titre du média">
        </div>

        {{-- Type --}}
        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                <option value="image">Image</option>
                <option value="video">Vidéo</option>
            </select>
        </div>

        {{-- URL (rempli automatiquement par Cloudinary) --}}
        <div class="mb-3">
            <label class="form-label">Fichier (URL Cloudinary)</label>
            <div class="input-group">
                <input type="text" name="url" id="url_input" class="form-control" placeholder="URL du média" readonly required>
                <button type="button" class="btn btn-outline-primary" id="upload_widget_btn">Uploader</button>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

{{-- Cloudinary Widget --}}
<script src="https://widget.cloudinary.com/v2.0/global/all.js"></script>
<script>
  const widget = cloudinary.createUploadWidget({
    cloudName: 'df2jerxfy',
    uploadPreset: 'default_preset', // 🔁 À remplacer par le tien
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
