<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;

class MediaApiController extends Controller
{
    /**
     * Retourne tous les médias.
     */
    public function index()
    {
        return response()->json(Media::latest()->get(), 200);
    }

    /**
     * Retourne un média par ID.
     */
    public function show($id)
    {
        $media = Media::find($id);

        if (!$media) {
            return response()->json(['message' => 'Média non trouvé'], 404);
        }

        return response()->json($media, 200);
    }
}
