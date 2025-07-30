<?php

namespace App\Http\Controllers;

use App\Models\StaffTechnique;
use Illuminate\Http\Request;

class StaffTechniqueController extends Controller
{
   public function index()
{
    return StaffTechnique::with('categorie')->get();
}
}
