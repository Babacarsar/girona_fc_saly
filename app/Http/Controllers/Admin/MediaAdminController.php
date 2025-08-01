<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MediaAdminController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(12);
        return view('admin.media.index', compact('media'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:51200', // 50 Mo max
            'titles.*' => 'nullable|string|max:255',
        ]);

        $files = $request->file('files') ?? [];
        $files = is_array($files) ? $files : [$files]; // ✅ Convertir en tableau si un seul fichier

        $titles = $request->input('titles');

        foreach ($files as $index => $file) {
            if (!$file || !$file->isValid()) continue;

            $ext = $file->getClientOriginalExtension();
            $type = in_array($ext, ['mp4', 'mov', 'avi']) ? 'video' : 'image';
            $title = $titles[$index] ?? null;

            // ✅ Upload vers Cloudinary
            $upload = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'media_girona',
                'resource_type' => $type === 'video' ? 'video' : 'image',
            ]);

            // ✅ Sauvegarde en base
            Media::create([
                'title' => $title,
                'type' => $type,
                'file_path' => $upload->getSecurePath(),
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', 'Médias ajoutés avec succès.');
    }

    public function edit(Media $media)
    {
        return view('admin.media.edit', compact('media'));
    }

    public function update(Request $request, Media $media)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'type' => 'required|in:image,video',
            'url' => 'required|url',
        ]);

        $media->update([
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $request->url,
        ]);

        return redirect()->route('admin.media.index')->with('success', 'Média mis à jour.');
    }

    public function destroy(Media $media)
    {
        // Optionnel : suppression Cloudinary
        $media->delete();
        return redirect()->back()->with('success', 'Média supprimé.');
    }
}
