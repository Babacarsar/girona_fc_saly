<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class EditorUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120',
        ]);

        $uploaded = Cloudinary::upload($request->file('file')->getRealPath(), [
            'folder' => 'actualites_editor',
        ]);

        return response()->json([
            'url' => $uploaded->getSecurePath(),
        ]);
    }
}
