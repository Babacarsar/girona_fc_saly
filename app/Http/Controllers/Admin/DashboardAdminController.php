<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Joueur;
use App\Models\StaffTechnique;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Statistiques globales
        $totalJoueurs = Joueur::count();
        $totalStaff = StaffTechnique::count();
        $totalCategories = Categorie::count();

        // Joueurs par mois (12 derniers mois)

        // Version MySQL :
        // $joueursParMois = Joueur::where('created_at', '>=', now()->subMonths(12))
        //     ->selectRaw("COUNT(*) as total, DATE_FORMAT(created_at, '%Y-%m') as mois")
        //     ->groupBy('mois')
        //     ->orderBy('mois')
        //     ->pluck('total', 'mois')
        //     ->toArray();

        // Version PostgreSQL :
        $joueursParMois = Joueur::where('created_at', '>=', now()->subMonths(12))
            ->selectRaw("COUNT(*) as total, TO_CHAR(created_at, 'YYYY-MM') as mois")
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('total', 'mois')
            ->toArray();

        // Joueurs par catégorie
        $joueursParCategorie = Joueur::with('categorie')
            ->get()
            ->groupBy('categorie.nom')
            ->map->count()
            ->toArray();

        // Derniers ajouts
        $derniersJoueurs = Joueur::latest()->take(3)->get();
        $dernierStaff = StaffTechnique::latest()->take(3)->get();

        return view('admin.dashboard', compact(
            'totalJoueurs',
            'totalStaff',
            'totalCategories',
            'joueursParMois',
            'joueursParCategorie',
            'derniersJoueurs',
            'dernierStaff'
        ));
    }
}
