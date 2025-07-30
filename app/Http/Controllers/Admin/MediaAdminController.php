<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        // Ignore si fichier vide ou invalide
        if (!$file || !$file->isValid()) {
            continue;
        }

        $title = $titles[$index] ?? null;
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '.' . $extension;

        // Crée le dossier public/upload/media si besoin
        $destination = public_path('upload/media');
        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        // Déplace le fichier
        $file->move($destination, $filename);

        // Enregistre dans la BDD
       Media::create([
    'title' => $title,
    'type' => in_array($extension, ['mp4', 'mov', 'avi']) ? 'video' : 'image',
    'file_path' => 'upload/media/' . $filename, // <- Nom correct attendu par la base
]);

    }

    return redirect()->route('admin.media.index')->with('success', 'Médias ajoutés avec succès.');
}
    public function destroy(Media $media)
    {
        Storage::disk('public')->delete($media->file_path);
        $media->delete();
        return redirect()->back()->with('success', 'Média supprimé.');
    }
}
