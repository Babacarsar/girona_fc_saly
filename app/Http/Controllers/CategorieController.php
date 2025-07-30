<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
   public function index()
{
    return Categorie::all();
}

public function store(Request $request)
{
    $categorie = Categorie::create($request->all());
    return response()->json($categorie, 201);
}

public function show(Categorie $categorie)
{
    return response()->json($categorie);
}

public function update(Request $request, Categorie $categorie)
{
    $categorie->update($request->all());
    return response()->json($categorie);
}

public function destroy(Categorie $categorie)
{
    $categorie->delete();
    return response()->json(['message' => 'Catégorie supprimée']);
}
public function joueurs($id)
{
    $categorie = Categorie::with('joueurs')->findOrFail($id);
    return response()->json($categorie->joueurs);
}
}
