<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Http\Request;

class ActualiteAdminController extends Controller
{
    public function index()
    {
        $actualites = Actualite::latest()->get();
        return view('admin.actualites.index', compact('actualites'));
    }

    public function create()
    {
        return view('admin.actualites.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filename = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/actualites'), $filename);
            $data['image'] = 'uploads/actualites/' . $filename;
        }

        Actualite::create($data);
        return redirect()->route('admin.actualites.index')->with('success', 'Actualité ajoutée avec succès.');
    }

    public function edit(Actualite $actualite)
    {
        return view('admin.actualites.edit', compact('actualite'));
    }

    public function update(Request $request, Actualite $actualite)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filename = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/actualites'), $filename);
            $data['image'] = 'uploads/actualites/' . $filename;
        }

        $actualite->update($data);
        return redirect()->route('admin.actualites.index')->with('success', 'Actualité mise à jour.');
    }

    public function destroy(Actualite $actualite)
    {
        $actualite->delete();
        return redirect()->route('admin.actualites.index')->with('success', 'Actualité supprimée.');
    }
}
