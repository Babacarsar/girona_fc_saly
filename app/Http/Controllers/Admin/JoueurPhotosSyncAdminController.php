<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Database\Seeders\JoueurPhotosSyncSeeder;
use Illuminate\Http\Request;

class JoueurPhotosSyncAdminController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'confirm' => 'required|in:photos',
        ]);

        set_time_limit(300);

        (new JoueurPhotosSyncSeeder)->run();

        return redirect()
            ->route('admin.joueurs.index')
            ->with('success', 'Photos synchronisées depuis joueur_photos/ (catégorie = nom du dossier).');
    }
}
