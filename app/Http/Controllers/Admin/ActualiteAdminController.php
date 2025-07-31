<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ActualiteAdminController extends Controller
{
    // Liste des actualités
    public function index()
    {
        $actualites = Actualite::latest()->get();
        return view('admin.actualites.index', compact('actualites'));
    }

    // Formulaire d'ajout
    public function create()
    {
        return view('admin.actualites.create');
    }

    // Enregistrement d'une nouvelle actualité
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre'             => 'required|string|max:255',
            'contenu'           => 'required|string',
            'auteur'            => 'nullable|string|max:100',
            'date_publication'  => 'nullable|date',
            'image'             => 'nullable|image|max:2048',
        ]);

        // Upload vers Cloudinary si image présente
        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'actualites_foot'
            ]);
            $data['image'] = $uploaded->getSecurePath();
            $data['image_public_id'] = $uploaded->getPublicId();
        }

        Actualite::create($data);

        return redirect()->route('admin.actualites.index')->with('success', 'Actualité ajoutée avec succès.');
    }

    // Formulaire de modification
    public function edit(Actualite $actualite)
    {
        return view('admin.actualites.edit', compact('actualite'));
    }

    // Mise à jour d'une actualité
    public function update(Request $request, Actualite $actualite)
    {
        $data = $request->validate([
            'titre'             => 'required|string|max:255',
            'contenu'           => 'required|string',
            'auteur'            => 'nullable|string|max:100',
            'date_publication'  => 'nullable|date',
            'image'             => 'nullable|image|max:2048',
        ]);

        // Supprimer l’ancienne image Cloudinary si nouvelle image envoyée
        if ($request->hasFile('image')) {
            if ($actualite->image_public_id) {
                Cloudinary::destroy($actualite->image_public_id);
            }

            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'actualites_foot'
            ]);
            $data['image'] = $uploaded->getSecurePath();
            $data['image_public_id'] = $uploaded->getPublicId();
        }

        $actualite->update($data);

        return redirect()->route('admin.actualites.index')->with('success', 'Actualité mise à jour.');
    }

    // Suppression d'une actualité
    public function destroy(Actualite $actualite)
    {
        if ($actualite->image_public_id) {
            Cloudinary::destroy($actualite->image_public_id);
        }

        $actualite->delete();

        return redirect()->route('admin.actualites.index')->with('success', 'Actualité supprimée.');
    }
}
