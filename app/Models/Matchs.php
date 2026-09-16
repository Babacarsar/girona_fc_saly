<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matchs extends Model
{
    protected $table = 'matchs';

    protected $fillable = [
        'adversaire',
        'date_match',
        'lieu',
        'score_domicile',
        'score_exterieur',
        'type',
        'categorie_id',
        'notes',
        'ordre',
    ];

    protected $casts = [
        'date_match' => 'datetime',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
}
