<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Actualite;

class ActualiteController extends Controller
{
    // GET /api/actualites
    public function index()
    {
        // Retourne toutes les actualités, les plus récentes en premier
        return response()->json(
            Actualite::orderBy('created_at', 'desc')->get()
        );
    }

    // GET /api/actualites/{id}
    public function show($id)
    {
        $actualite = Actualite::findOrFail($id);
        return response()->json($actualite);
    }
}
