<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreInscription extends Model
{
    protected $fillable = [
        'prenom',
        'nom',
        'date_naissance',
        'categorie_id',
        'email_parent',
        'telephone',
        'message',
        'traite',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'traite' => 'boolean',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
}
