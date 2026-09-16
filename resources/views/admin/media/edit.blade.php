@extends('layouts.admin')

@section('title', 'Modifier média')

@section('content')
<x-admin.page-header title="Modifier le média" breadcrumb='<a href="'.route('admin.media.index').'">Médias</a> / Édition' />

<div class="admin-card col-lg-8">
    <div class="admin-card__body admin-form">
        <x-admin.validation-errors />
        <form action="{{ route('admin.media.update', $media) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $media->title) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" id="type_input" class="form-select" required>
                    <option value="image" @selected($media->type === 'image')>Image</option>
                    <option value="video" @selected($media->type === 'video')>Vidéo</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">URL Cloudinary</label>
                <div class="input-group">
                    <input type="url" name="url" id="url_input" class="form-control" value="{{ old('url', $media->file_path) }}" required>
                    <button type="button" class="btn btn-girona" id="upload_widget_btn">Remplacer</button>
                </div>
            </div>
            <div class="mb-4 rounded overflow-hidden border">
                @if ($media->type === 'video')
                    <video class="w-100" controls><source src="{{ $media->file_path }}"></video>
                @else
                    <img src="{{ $media->file_path }}" alt="" class="w-100">
                @endif
            </div>
            <button type="submit" class="btn btn-girona">Mettre à jour</button>
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
        resourceType: 'auto'
    }, (error, result) => {
        if (!error && result?.event === 'success') {
            document.getElementById('url_input').value = result.info.secure_url;
            document.getElementById('type_input').value = result.info.resource_type === 'video' ? 'video' : 'image';
        }
    });
    document.getElementById('upload_widget_btn')?.addEventListener('click', () => widget.open());
</script>
@endpush
