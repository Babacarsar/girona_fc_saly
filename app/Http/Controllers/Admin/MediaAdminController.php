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
    $validated = $request->validate([
        'title' => 'nullable|string|max:255',
        'type' => 'required|in:image,video',
        'url' => 'required|url'
    ]);

    Media::create([
        'title' => $validated['title'],
        'type' => $validated['type'],
        'file_path' => $validated['url'],
    ]);

    return redirect()->route('admin.media.index')->with('success', 'Média ajouté avec succès.');
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
