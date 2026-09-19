<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Database\Seeders\GironaRosterImportSeeder;
use Illuminate\Http\Request;

class RosterImportAdminController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'confirm' => 'required|in:import',
        ]);

        (new GironaRosterImportSeeder)->run();

        return redirect()
            ->route('admin.joueurs.index')
            ->with('success', 'Effectif remplacé depuis la base Excel (catégories U13–U19, joueurs U13/U15).');
    }
}
