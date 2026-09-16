<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partenaire;
use Illuminate\Http\Request;

class PartenaireAdminController extends Controller
{
    public function index()
    {
        $partenaires = Partenaire::orderBy('ordre')->orderBy('nom')->paginate(20);

        return view('admin.partenaires.index', compact('partenaires'));
    }

    public function create()
    {
        return view('admin.partenaires.create');
    }

    public function store(Request $request)
    {
        Partenaire::create($this->validated($request));

        return redirect()->route('admin.partenaires.index')->with('success', 'Partenaire ajouté.');
    }

    public function edit(Partenaire $partenaire)
    {
        return view('admin.partenaires.edit', compact('partenaire'));
    }

    public function update(Request $request, Partenaire $partenaire)
    {
        $partenaire->update($this->validated($request));

        return redirect()->route('admin.partenaires.index')->with('success', 'Partenaire mis à jour.');
    }

    public function destroy(Partenaire $partenaire)
    {
        $partenaire->delete();

        return redirect()->route('admin.partenaires.index')->with('success', 'Partenaire supprimé.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:partenaires,id']);

        foreach ($request->ids as $index => $id) {
            Partenaire::where('id', $id)->update(['ordre' => $index]);
        }

        return back()->with('success', 'Ordre des partenaires mis à jour.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'logo' => 'required|url|max:500',
            'description' => 'nullable|string|max:500',
            'url' => 'nullable|url|max:500',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'nullable|boolean',
        ]);

        $data['actif'] = $request->boolean('actif', true);
        $data['ordre'] = $data['ordre'] ?? (int) Partenaire::max('ordre') + 1;

        return $data;
    }
}
