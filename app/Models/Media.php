<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',      // exemple: photo ou video
        'path',    // lien de la photo ou vidéo
        'title',     // titre du média
        'description', // texte descriptif
    ];
}
