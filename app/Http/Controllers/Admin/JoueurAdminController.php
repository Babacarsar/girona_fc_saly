<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Joueur;
use App\Support\AdminListing;
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

        if ($request->filled('q')) {
            $q = '%'.$request->q.'%';
            $joueurs->where(function ($query) use ($q) {
                $query->where('nom', 'ilike', $q)
                    ->orWhere('prenom', 'ilike', $q)
                    ->orWhere('poste', 'ilike', $q);
            });
        }

        $joueurs = AdminListing::applySort(
            $joueurs,
            $request,
            ['nom', 'prenom', 'poste', 'ordre', 'created_at'],
            'ordre',
            'asc'
        )->paginate(20)->withQueryString();

        return view('admin.joueurs.index', [
            'joueurs' => $joueurs,
            'categories' => $categories,
            'selectedCategorie' => $request->categorie_id,
        ]);
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:joueurs,id']);

        foreach ($request->ids as $index => $id) {
            Joueur::where('id', $id)->update(['ordre' => $index]);
        }

        return back()->with('success', 'Ordre des joueurs mis à jour.');
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('admin.joueurs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
    'nom'         => 'required|string|max:255',
    'prenom'      => 'required|string|max:255', // ✅ manquant
    'categorie_id'=> 'required|exists:categories,id',
    'poste'       => 'nullable|string|max:255',
    'numero'      => 'nullable|integer',
    'photo'       => 'nullable|image|max:2048',
    'photo_url'   => 'nullable|url|max:500',
]);

        if ($request->hasFile('photo')) {
            $uploaded = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' => 'joueurs_foot'
            ]);
            $data['photo'] = $uploaded->getSecurePath();
        } elseif ($request->filled('photo_url')) {
            $data['photo'] = $request->input('photo_url');
        }

        unset($data['photo_url']);
        $data['ordre'] = (int) Joueur::max('ordre') + 1;
        $data['age'] = null;
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
    'nom'         => 'required|string|max:255',
    'prenom'      => 'required|string|max:255', // ✅ manquant
    'categorie_id'=> 'required|exists:categories,id',
    'poste'       => 'nullable|string|max:255',
    'numero'      => 'nullable|integer',
    'photo'       => 'nullable|image|max:2048',
    'photo_url'   => 'nullable|url|max:500',
]);

        if ($request->hasFile('photo')) {
            $uploaded = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' => 'joueurs_foot'
            ]);
            $data['photo'] = $uploaded->getSecurePath();
        } elseif ($request->filled('photo_url')) {
            $data['photo'] = $request->input('photo_url');
        }

        unset($data['photo_url']);
        $joueur->update($data);
        return redirect()->route('admin.joueurs.index')->with('success', 'Joueur mis à jour.');
    }

    public function destroy(Joueur $joueur)
    {
        $joueur->delete();
        return redirect()->route('admin.joueurs.index')->with('success', 'Joueur supprimé.');
    }
}
