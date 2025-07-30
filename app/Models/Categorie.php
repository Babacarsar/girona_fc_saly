<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = ['nom'];
    /** * Get the joueurs for the category.
     */
    public function joueurs()
    {
        return $this->hasMany(Joueur::class);
    }
    
   
}
