<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    // Table associée (optionnel si le nom est 'media')
    protected $table = 'media';

    // Champs pouvant être remplis
    protected $fillable = [
        'titre',  // ou 'title' si tu as gardé l'anglais
        'url',
        'type',   // 'image' ou 'video'
    ];
}
