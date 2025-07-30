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
            'files.*' => 'required|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:20480',
            'titles.*' => 'required|string|max:255',
        ]);

        foreach ($request->file('files') as $i => $file) {
            $path = $file->store('uploads', 'public');
            $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

            Media::create([
                'title' => $request->titles[$i],
                'file_path' => $path,
                'type' => $type,
            ]);
        }

        return redirect()->back()->with('success', 'Médias uploadés avec succès !');
    }

    public function destroy(Media $media)
    {
        Storage::disk('public')->delete($media->file_path);
        $media->delete();

        return redirect()->back()->with('success', 'Média supprimé.');
    }
}
