@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>📤 Ajouter des médias (images ou vidéos)</h2>

    {{-- Messages d’erreur --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Message succès --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulaire --}}
    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div id="upload-container">
            <div class="upload-group row mb-3">
                <div class="col-md-5">
                    <label class="form-label">Fichier</label>
                    <input type="file" name="files[]" class="form-control" accept="image/*,video/*" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Titre <small class="text-muted">(facultatif)</small></label>
                    <input type="text" name="titles[]" class="form-control" placeholder="Titre du média">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove" onclick="removeUploadField(this)">X</button>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-outline-primary" onclick="addUploadField()">+ Ajouter un autre média</button>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">✅ Enregistrer</button>
            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

{{-- JS pour ajouter/supprimer des champs dynamiques --}}
<script>
    function addUploadField() {
        const container = document.getElementById('upload-container');
        const group = document.createElement('div');
        group.classList.add('upload-group', 'row', 'mb-3');
        group.innerHTML = `
            <div class="col-md-5">
                <input type="file" name="files[]" class="form-control" accept="image/*,video/*" required>
            </div>
            <div class="col-md-5">
                <input type="text" name="titles[]" class="form-control" placeholder="Titre du média">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-remove" onclick="removeUploadField(this)">X</button>
            </div>
        `;
        container.appendChild(group);
    }

    function removeUploadField(button) {
        const group = button.closest('.upload-group');
        group.remove();
    }
</script>
@endsection
