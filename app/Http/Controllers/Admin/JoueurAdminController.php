<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Joueur;
use Illuminate\Http\Request;

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
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('uploads/joueurs'), $filename);
            $data['photo'] = 'uploads/joueurs/' . $filename;
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
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('uploads/joueurs'), $filename);
            $data['photo'] = 'uploads/joueurs/' . $filename;
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
