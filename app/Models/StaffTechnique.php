<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffTechnique extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'prenom', 'role', 'categorie_id', 'photo'];

public function categorie()
{
    return $this->belongsTo(Categorie::class);
}
}
