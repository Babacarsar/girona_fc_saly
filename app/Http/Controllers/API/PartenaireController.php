<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Partenaire;

class PartenaireController extends Controller
{
    public function index()
    {
        return Partenaire::active()
            ->orderBy('ordre')
            ->orderBy('nom')
            ->get()
            ->map(function (Partenaire $partenaire) {
                $data = $partenaire->toArray();
                $data['logo'] = admin_media_url($partenaire->logo, $partenaire->nom);

                return $data;
            });
    }
}
