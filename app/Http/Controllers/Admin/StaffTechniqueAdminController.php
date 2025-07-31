<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffTechnique;
use App\Models\Categorie;
use Illuminate\Http\Request;

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
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('upload/staff'), $filename);
            $data['photo'] = 'upload/staff/' . $filename;
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
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('upload/staff'), $filename);
            $data['photo'] = 'upload/staff/' . $filename;
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
