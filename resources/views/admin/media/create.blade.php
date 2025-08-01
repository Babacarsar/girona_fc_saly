@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Ajouter des médias</h2>

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

    <form id="media-form" action="{{ route('admin.media.store') }}" method="POST" onsubmit="return handleUpload()">
        @csrf

        <div id="upload-container">
            <div class="upload-group row mb-3">
                <div class="col-md-5">
                    <label class="form-label">Fichier</label>
                    <input type="file" class="form-control file-input" accept="image/*,video/*" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Titre <small class="text-muted">(facultatif)</small></label>
                    <input type="text" class="form-control title-input" placeholder="Titre du média">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove" onclick="removeUploadField(this)">X</button>
                </div>
            </div>
        </div>

        {{-- Hidden inputs will be injected here --}}
        <div id="hidden-inputs"></div>

        <div class="mb-3">
            <button type="button" class="btn btn-outline-primary" onclick="addUploadField()">+ Ajouter un autre média</button>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">Enregistrer</button>
            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

{{-- Cloudinary Upload Script --}}
<script>
    const cloudName = 'df2jerxfy'; // remplace par ton cloud_name
    const uploadPreset = 'media_unsigned'; // remplace par ton preset non authentifié

    function addUploadField() {
        const container = document.getElementById('upload-container');
        const group = document.createElement('div');
        group.classList.add('upload-group', 'row', 'mb-3');
        group.innerHTML = `
            <div class="col-md-5">
                <input type="file" class="form-control file-input" accept="image/*,video/*" required>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control title-input" placeholder="Titre du média">
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

    async function handleUpload() {
        const fileInputs = document.querySelectorAll('.file-input');
        const titleInputs = document.querySelectorAll('.title-input');
        const hiddenInputsContainer = document.getElementById('hidden-inputs');

        hiddenInputsContainer.innerHTML = ''; // Reset

        for (let i = 0; i < fileInputs.length; i++) {
            const file = fileInputs[i].files[0];
            const title = titleInputs[i].value;

            if (!file) continue;

            const formData = new FormData();
            formData.append('file', file);
            formData.append('upload_preset', uploadPreset);

            const res = await fetch(`https://api.cloudinary.com/v1_1/${cloudName}/auto/upload`, {
                method: 'POST',
                body: formData
            });

            const data = await res.json();

            // Inject hidden inputs
            hiddenInputsContainer.innerHTML += `
                <input type="hidden" name="url" value="${data.secure_url}">
                <input type="hidden" name="type" value="${file.type.startsWith('video') ? 'video' : 'image'}">
                <input type="hidden" name="title" value="${title}">
            `;
        }

        return true; // Submit the form
    }
</script>
@endsection
