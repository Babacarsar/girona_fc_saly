<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joueur extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'prenom', 'age', 'poste', 'categorie_id', 'photo'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
