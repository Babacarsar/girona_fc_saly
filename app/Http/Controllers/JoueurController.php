<?php

namespace App\Http\Controllers;

use App\Models\Joueur;

class JoueurController extends Controller
{
    public function index()
    {
        return Joueur::with('categorie')
            ->orderBy('ordre')
            ->orderBy('nom')
            ->get();
    }

    public function show(Joueur $joueur)
    {
        return $joueur->load('categorie');
    }
}
