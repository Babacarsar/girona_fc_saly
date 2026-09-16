<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use App\Support\AdminListing;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ActualiteAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Actualite::query();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $actualites = AdminListing::applySort(
            $query,
            $request,
            ['titre', 'created_at', 'ordre', 'statut'],
            'ordre',
            'asc'
        )->paginate(15)->withQueryString();

        return view('admin.actualites.index', compact('actualites'));
    }

    public function create()
    {
        return view('admin.actualites.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'actualites_foot',
            ]);
            $data['image'] = $uploaded->getSecurePath();
            $data['image_public_id'] = $uploaded->getPublicId();
        }

        if (! isset($data['ordre'])) {
            $data['ordre'] = (int) Actualite::max('ordre') + 1;
        }

        Actualite::create($data);

        return redirect()->route('admin.actualites.index')->with('success', 'Actualité enregistrée.');
    }

    public function edit(Actualite $actualite)
    {
        return view('admin.actualites.edit', compact('actualite'));
    }

    public function update(Request $request, Actualite $actualite)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($actualite->image_public_id) {
                Cloudinary::destroy($actualite->image_public_id);
            }
            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'actualites_foot',
            ]);
            $data['image'] = $uploaded->getSecurePath();
            $data['image_public_id'] = $uploaded->getPublicId();
        }

        $actualite->update($data);

        return redirect()->route('admin.actualites.index')->with('success', 'Actualité mise à jour.');
    }

    public function destroy(Actualite $actualite)
    {
        if ($actualite->image_public_id) {
            Cloudinary::destroy($actualite->image_public_id);
        }
        $actualite->delete();

        return redirect()->route('admin.actualites.index')->with('success', 'Actualité supprimée.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:actualites,id']);

        foreach ($request->ids as $index => $id) {
            Actualite::where('id', $id)->update(['ordre' => $index]);
        }

        return back()->with('success', 'Ordre des actualités mis à jour.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'auteur' => 'nullable|string|max:100',
            'date_publication' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'statut' => 'required|in:draft,published',
            'ordre' => 'nullable|integer|min:0',
            'a_la_une' => 'nullable|boolean',
        ]);

        $data['a_la_une'] = $request->boolean('a_la_une');

        return $data;
    }
}
