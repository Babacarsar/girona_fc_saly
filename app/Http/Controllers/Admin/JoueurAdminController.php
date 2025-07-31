<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Joueur;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class JoueurAdminController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categorie::all();
        $joueurs = Joueur::with('categorie');

        if ($request->filled('categorie_id')) {
            $joueurs->where('categorie_id', $request->categorie_id);
        }

        return view('admin.joueurs.index', [
            'joueurs' => $joueurs->get(),
            'categories' => $categories,
            'selectedCategorie' => $request->categorie_id
        ]);
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('admin.joueurs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'poste' => 'nullable|string|max:255',
            'numero' => 'nullable|integer',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $uploaded = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' => 'joueurs_foot'
            ]);
            $data['photo'] = $uploaded->getSecurePath();
        }

        Joueur::create($data);
        return redirect()->route('admin.joueurs.index')->with('success', 'Joueur ajouté avec succès.');
    }

    public function edit(Joueur $joueur)
    {
        $categories = Categorie::all();
        return view('admin.joueurs.edit', compact('joueur', 'categories'));
    }

    public function update(Request $request, Joueur $joueur)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'poste' => 'nullable|string|max:255',
            'numero' => 'nullable|integer',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $uploaded = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' => 'joueurs_foot'
            ]);
            $data['photo'] = $uploaded->getSecurePath();
        }

        $joueur->update($data);
        return redirect()->route('admin.joueurs.index')->with('success', 'Joueur mis à jour.');
    }

    public function destroy(Joueur $joueur)
    {
        $joueur->delete();
        return redirect()->route('admin.joueurs.index')->with('success', 'Joueur supprimé.');
    }
}
