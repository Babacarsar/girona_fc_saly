<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StaffTechnique;

class StaffTechniqueController extends Controller
{
    /**
     * Afficher tous les membres du staff technique avec leur catégorie.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $staff = StaffTechnique::with('categorie')->get();
        return response()->json($staff);
    }
}
