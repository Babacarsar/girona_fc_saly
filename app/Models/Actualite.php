<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    use HasFactory;

    public const STATUT_BROUILLON = 'draft';

    public const STATUT_PUBLIE = 'published';

    protected $fillable = [
        'titre',
        'contenu',
        'image',
        'image_public_id',
        'auteur',
        'date_publication',
        'ordre',
        'statut',
        'a_la_une',
    ];

    protected $casts = [
        'a_la_une' => 'boolean',
        'date_publication' => 'date',
    ];

    public function scopePublished($query)
    {
        return $query->where('statut', self::STATUT_PUBLIE);
    }
}
