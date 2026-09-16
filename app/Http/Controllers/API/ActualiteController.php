<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Actualite;

class ActualiteController extends Controller
{
    public function index()
    {
        return response()->json(
            Actualite::published()
                ->orderByDesc('a_la_une')
                ->orderBy('ordre')
                ->orderByDesc('created_at')
                ->get()
        );
    }

    public function show($id)
    {
        $actualite = Actualite::published()->findOrFail($id);

        return response()->json($actualite);
    }
}
