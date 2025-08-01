<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;

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
        // ✅ On ne reçoit que l’URL et le type, pas le fichier
        $request->validate([
            'url'   => 'required|url',
            'title' => 'nullable|string|max:255',
            'type'  => 'required|in:image,video',
        ]);

        Media::create([
            'title'     => $request->input('title'),
            'type'      => $request->input('type'),
            'file_path' => $request->input('url'), // Cloudinary URL
        ]);

        return redirect()->route('admin.media.index')->with('success', 'Média enregistré avec succès.');
    }

    public function destroy(Media $media)
    {
        $media->delete();
        return redirect()->back()->with('success', 'Média supprimé.');
    }
}
