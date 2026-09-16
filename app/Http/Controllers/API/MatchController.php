<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Matchs;

class MatchController extends Controller
{
    public function index()
    {
        return Matchs::with('categorie')
            ->orderBy('date_match')
            ->get();
    }
}
