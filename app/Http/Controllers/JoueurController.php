<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use Illuminate\Http\Request;

class JoueurController extends Controller
{ 
    public function index()
    {
        return Joueur::with('categorie')->get();
    }
}
