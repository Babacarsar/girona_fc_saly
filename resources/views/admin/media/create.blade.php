@extends('layouts.admin')

@section('title', 'Nouveau média')

@section('content')
<x-admin.page-header title="Ajouter un média" description="Upload via le widget Cloudinary." breadcrumb='<a href="'.route('admin.media.index').'">Médias</a> / Création' />

<div class="admin-card col-lg-8">
    <div class="admin-card__body admin-form">
        <x-admin.validation-errors />
        <form action="{{ route('admin.media.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Optionnel">
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" id="type_input" class="form-select" required>
                    <option value="">— Sélectionner après upload —</option>
                    <option value="image">Image</option>
                    <option value="video">Vidéo</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label">Fichier Cloudinary</label>
                <div class="input-group">
                    <input type="url" name="url" id="url_input" class="form-control" readonly required placeholder="Cliquez sur Uploader">
                    <button type="button" class="btn btn-girona" id="upload_widget_btn"><i class="bi bi-cloud-upload"></i> Uploader</button>
                </div>
            </div>
            <button type="submit" class="btn btn-girona">Enregistrer</button>
            <a href="{{ route('admin.media.index') }}" class="btn btn-light">Annuler</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://widget.cloudinary.com/v2.0/global/all.js"></script>
<script>
    const cloudName = @json(config('cloudinary.cloud_name', ''));
    const widget = cloudinary.createUploadWidget({
        cloudName: cloudName || 'df2jerxfy',
        uploadPreset: 'girona_unsigned',
        folder: 'media_girona',
        multiple: false,
        resourceType: 'auto'
    }, (error, result) => {
        if (!error && result?.event === 'success') {
            document.getElementById('url_input').value = result.info.secure_url;
            document.getElementById('type_input').value = result.info.resource_type === 'video' ? 'video' : 'image';
        } else if (error) {
            alert('Erreur upload : ' + error.message);
        }
    });
    document.getElementById('upload_widget_btn')?.addEventListener('click', () => widget.open());
</script>
@endpush
