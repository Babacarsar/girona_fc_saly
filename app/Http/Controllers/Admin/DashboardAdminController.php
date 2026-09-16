<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use App\Models\Categorie;
use App\Models\Joueur;
use App\Models\Media;
use App\Models\StaffTechnique;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $totalJoueurs = Joueur::count();
        $totalStaff = StaffTechnique::count();
        $totalCategories = Categorie::count();
        $totalActualites = Actualite::count();
        $totalMedia = Media::count();

        $joueursParMois = Joueur::where('created_at', '>=', now()->subMonths(12))
            ->selectRaw("COUNT(*) as total, TO_CHAR(created_at, 'YYYY-MM') as mois")
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('total', 'mois')
            ->toArray();

        $joueursParCategorie = Joueur::with('categorie')
            ->get()
            ->groupBy(fn ($j) => $j->categorie->nom ?? 'Sans catégorie')
            ->map->count()
            ->toArray();

        $derniersJoueurs = Joueur::with('categorie')->latest()->take(5)->get();
        $dernierStaff = StaffTechnique::with('categorie')->latest()->take(5)->get();
        $dernieresActualites = Actualite::latest()->take(4)->get();

        return view('admin.dashboard', compact(
            'totalJoueurs',
            'totalStaff',
            'totalCategories',
            'totalActualites',
            'totalMedia',
            'joueursParMois',
            'joueursParCategorie',
            'derniersJoueurs',
            'dernierStaff',
            'dernieresActualites'
        ));
    }
}
