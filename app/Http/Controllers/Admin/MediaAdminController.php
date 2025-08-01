<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MediaadminController extends Controller
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
            'files.*' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
            'titles.*' => 'nullable|string|max:255',
        ]);

        $files = $request->file('files');
        $titles = $request->input('titles');

        foreach ($files as $index => $file) {
            if (!$file || !$file->isValid()) continue;

            $extension = $file->getClientOriginalExtension();
            $type = in_array($extension, ['mp4', 'mov', 'avi']) ? 'video' : 'image';
            $title = $titles[$index] ?? null;

            // Upload to Cloudinary
            $uploaded = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'media_girona',
                'resource_type' => $type === 'video' ? 'video' : 'image'
            ]);

            // Save to DB
            Media::create([
                'titre' => $title,
                'type' => $type,
                'url' => $uploaded->getSecurePath(),
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', 'Médias ajoutés avec succès.');
    }

    public function destroy(Media $media)
    {
        // Optionnel : suppression sur Cloudinary si tu stockes le public_id
        $media->delete();
        return redirect()->back()->with('success', 'Média supprimé.');
    }
}
