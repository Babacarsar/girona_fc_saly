@extends('admin.layout')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Modifier un média</h1>

    <form action="{{ route('admin.media.update', $media->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Type</label>
            <select name="type" class="border w-full p-2">
                <option value="photo" {{ $media->type === 'photo' ? 'selected' : '' }}>Photo</option>
                <option value="video" {{ $media->type === 'video' ? 'selected' : '' }}>Vidéo</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium">URL</label>
            <input type="text" name="url" value="{{ $media->url }}" class="border w-full p-2" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
@endsection
