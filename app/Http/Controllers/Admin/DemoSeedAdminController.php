<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Database\Seeders\ClubDemoSeeder;
use Illuminate\Http\Request;

class DemoSeedAdminController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'confirm' => 'required|in:demo',
        ]);

        set_time_limit(300);

        (new ClubDemoSeeder)->run();

        return redirect()->route('admin.dashboard')->with('success', 'Données de démonstration chargées (sans écraser les enregistrements existants par module).');
    }
}
