<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaadminController extends Controller
{
    public function index()
    {
        $media = Media::latest()->get();
        return view('admin.media.index', compact('media'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'type' => 'required|in:image,video',
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);

        $filename = Str::uuid() . '.' . $request->file('file')->getClientOriginalExtension();
        $path = $request->file('file')->storeAs('public/media', $filename);

        Media::create([
            'title' => $request->title,
            'type' => $request->type,
            'path' => str_replace('public/', '', $path),
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
            'path' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);

        if ($request->hasFile('path')) {
            // Supprimer l’ancien fichier
            if ($media->path) {
                Storage::delete('public/' . $media->path);
            }

            // Enregistrer le nouveau
            $filename = Str::uuid() . '.' . $request->file('path')->getClientOriginalExtension();
            $newPath = $request->file('path')->storeAs('public/media', $filename);
            $media->path = str_replace('public/', '', $newPath);
        }

        $media->title = $request->title;
        $media->type = $request->type;
        $media->save();

        return redirect()->route('admin.media.index')->with('success', 'Média mis à jour.');
    }

  public function destroy(Media $medium)
{
    Storage::delete('public/' . $medium->path);
    $medium->delete();

    return back()->with('success', 'Média supprimé.');
}
}
