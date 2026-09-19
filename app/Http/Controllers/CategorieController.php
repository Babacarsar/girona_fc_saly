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

public function show(Categorie $category)
{
    return response()->json($category);
}

public function update(Request $request, Categorie $category)
{
    $category->update($request->all());
    return response()->json($category);
}

public function destroy(Categorie $category)
{
    $category->delete();
    return response()->json(['message' => 'Catégorie supprimée']);
}
public function joueurs($id)
{
    $categorie = Categorie::with('joueurs')->findOrFail($id);
    return response()->json($categorie->joueurs);
}
}
