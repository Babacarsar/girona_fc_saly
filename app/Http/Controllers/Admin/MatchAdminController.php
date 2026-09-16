<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Matchs;
use Illuminate\Http\Request;

class MatchAdminController extends Controller
{
    public function index()
    {
        $matchs = Matchs::with('categorie')->orderBy('date_match')->paginate(20);

        return view('admin.matchs.index', compact('matchs'));
    }

    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.matchs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Matchs::create($this->validated($request));

        return redirect()->route('admin.matchs.index')->with('success', 'Match enregistré.');
    }

    public function edit(Matchs $matchs)
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.matchs.edit', ['match' => $matchs, 'categories' => $categories]);
    }

    public function update(Request $request, Matchs $matchs)
    {
        $matchs->update($this->validated($request));

        return redirect()->route('admin.matchs.index')->with('success', 'Match mis à jour.');
    }

    public function destroy(Matchs $matchs)
    {
        $matchs->delete();

        return redirect()->route('admin.matchs.index')->with('success', 'Match supprimé.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'adversaire' => 'required|string|max:255',
            'date_match' => 'required|date',
            'lieu' => 'nullable|string|max:255',
            'score_domicile' => 'nullable|string|max:20',
            'score_exterieur' => 'nullable|string|max:20',
            'type' => 'required|in:amical,tournoi',
            'categorie_id' => 'nullable|exists:categories,id',
            'notes' => 'nullable|string|max:2000',
        ]);
    }
}
