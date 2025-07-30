<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieAdminController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        Categorie::create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie ajoutée.');
    }

    public function edit(Categorie $category)
    {
         $categorie = $category;
    return view('admin.categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $category)
    {
        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour.');
    }

    public function destroy(Categorie $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée.');
    }
}
