<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Joueur;
use App\Support\JoueurPhotoFilename;
use App\Support\JoueurPhotoImport;
use Illuminate\Database\Seeder;

class JoueurPhotosSyncSeeder extends Seeder
{
    public function run(): void
    {
        $catIds = Categorie::query()->pluck('id', 'nom')->all();
        $updated = 0;
        $skipped = 0;

        foreach (JoueurPhotoImport::discoverPhotos() as $photo) {
            $catNom = JoueurPhotoImport::normalizeCategory($photo['categorie']);
            $catId = $catIds[$catNom] ?? null;
            if ($catId === null) {
                $skipped++;

                continue;
            }

            $key = JoueurPhotoFilename::normalizeKey($photo['prenom'], $photo['nom']);
            $joueur = Joueur::query()
                ->where('categorie_id', $catId)
                ->get()
                ->first(fn (Joueur $j) => JoueurPhotoFilename::normalizeKey($j->prenom, $j->nom) === $key);

            if ($joueur === null) {
                $skipped++;

                continue;
            }

            $url = JoueurPhotoImport::publishPhoto(
                $photo['source'],
                $photo['prenom'],
                $photo['nom'],
                $photo['filename']
            );

            $joueur->update(['photo' => $url]);
            $updated++;
        }

        $this->command?->info("Photos joueurs : {$updated} mises à jour, {$skipped} ignorées (catégorie ou joueur introuvable).");
    }
}
