<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Joueur;
use App\Models\Matchs;
use App\Models\PreInscription;
use App\Models\StaffTechnique;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GironaRosterImportSeeder extends Seeder
{
    private const DEFAULT_AGE = [
        'U13' => 13,
        'U15' => 15,
        'U17' => 17,
        'U19' => 19,
    ];

    public function run(): void
    {
        $path = database_path('seeders/data/girona_roster.json');
        if (! is_file($path)) {
            throw new \RuntimeException('Missing girona_roster.json — run export from Excel first.');
        }

        $payload = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        $categories = $payload['categories'] ?? [];
        $joueurs = $payload['joueurs'] ?? [];

        DB::transaction(function () use ($categories, $joueurs) {
            Joueur::query()->delete();
            StaffTechnique::query()->delete();
            PreInscription::query()->delete();
            Matchs::query()->update(['categorie_id' => null]);
            Categorie::query()->delete();

            $catIds = [];
            foreach ($categories as $nom) {
                $cat = Categorie::create(['nom' => $nom]);
                $catIds[$nom] = $cat->id;
            }

            $ordre = 0;
            foreach ($joueurs as $row) {
                $catNom = $row['categorie'];
                if (! isset($catIds[$catNom])) {
                    continue;
                }
                $poste = $row['poste'] ?? 'Inconnu';
                Joueur::create([
                    'nom' => $row['nom'],
                    'prenom' => $row['prenom'],
                    'age' => self::DEFAULT_AGE[$catNom] ?? 15,
                    'poste' => $poste,
                    'categorie_id' => $catIds[$catNom],
                    'photo' => null,
                    'ordre' => $ordre++,
                ]);
            }
        });

        $this->command?->info('Roster import: '.count($categories).' categories, '.count($joueurs).' joueurs.');
    }
}
