<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffTechnique;
use App\Models\Categorie;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class StaffTechniqueAdminController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categorie::all();
        $staff = StaffTechnique::with('categorie');

        if ($request->filled('categorie_id')) {
            $staff->where('categorie_id', $request->categorie_id);
        }

        return view('admin.staff.index', [
            'staff' => $staff->get(),
            'categories' => $categories,
            'selectedCategorie' => $request->categorie_id
        ]);
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('admin.staff.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'          => 'required|string|max:255',
            'prenom'       => 'required|string|max:255',
            'poste'        => 'nullable|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'photo'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $uploaded = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' => 'staff_technique'
            ]);
            $data['photo'] = $uploaded->getSecurePath();
        }

        StaffTechnique::create($data);
        return redirect()->route('admin.staff.index')->with('success', 'Membre du staff ajouté.');
    }

    public function edit(StaffTechnique $staff)
    {
        $categories = Categorie::all();
        return view('admin.staff.edit', compact('staff', 'categories'));
    }

    public function update(Request $request, StaffTechnique $staff)
    {
        $data = $request->validate([
            'nom'          => 'required|string|max:255',
            'prenom'       => 'required|string|max:255',
            'poste'        => 'nullable|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'photo'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $uploaded = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' => 'staff_technique'
            ]);
            $data['photo'] = $uploaded->getSecurePath();
        }

        $staff->update($data);
        return redirect()->route('admin.staff.index')->with('success', 'Membre du staff mis à jour.');
    }

    public function destroy(StaffTechnique $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Membre du staff supprimé.');
    }
}
