<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * --- API ROUTES ---
     */

    // GET /api/categories
    public function index()
    {
        return response()->json(Categorie::all());
    }

    // POST /api/categories
    public function store(Request $request)
    {
        $categorie = Categorie::create($request->all());
        return response()->json($categorie, 201);
    }

    // GET /api/categories/{id}
    public function show($id)
    {
        $categorie = Categorie::with('joueurs')->find($id);

        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }

        return response()->json($categorie);
    }

    // PUT /api/categories/{id}
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->update($request->all());
        return response()->json($categorie);
    }

    // DELETE /api/categories/{id}
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();

        return response()->json(['message' => 'Catégorie supprimée']);
    }

    // GET /api/categories/{id}/joueurs
    public function joueurs($id)
    {
        $categorie = Categorie::with('joueurs')->find($id);

        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }

        return response()->json($categorie->joueurs);
    }


    /**
     * --- ADMIN ROUTES (Web) ---
     */

    // GET /admin/categories/{id}/edit
    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('admin.categories.edit', compact('categorie'));
    }
}
