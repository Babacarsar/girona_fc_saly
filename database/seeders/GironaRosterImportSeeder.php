<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Joueur;
use App\Models\Matchs;
use App\Models\PreInscription;
use App\Models\StaffTechnique;
use App\Support\JoueurPhotoFilename;
use App\Support\JoueurPhotoImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GironaRosterImportSeeder extends Seeder
{
    private const DEFAULT_AGE = [
        'U13' => 13,
        'U15' => 15,
        'U17' => 17,
        'U19' => 19,
        'Senior' => 20,
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

        $this->mergeSeniorGoalkeepersFromPhotos($categories, $joueurs);
        $photoByPlayer = $this->indexDiscoveredPhotos();

        DB::transaction(function () use ($categories, $joueurs, $photoByPlayer) {
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
                $photo = $this->resolveJoueurPhoto($row, $catNom, $photoByPlayer);

                Joueur::create([
                    'nom' => $row['nom'],
                    'prenom' => $row['prenom'],
                    'age' => self::DEFAULT_AGE[$catNom] ?? 15,
                    'poste' => $poste,
                    'categorie_id' => $catIds[$catNom],
                    'photo' => $photo,
                    'ordre' => $ordre++,
                ]);
            }
        });

        $this->command?->info('Roster import: '.count($categories).' categories, '.count($joueurs).' joueurs.');
    }

    /**
     * @return array<string, array{categorie: string, prenom: string, nom: string, poste: string|null, source: string, filename: string}>
     */
    private function indexDiscoveredPhotos(): array
    {
        $map = [];
        foreach (JoueurPhotoImport::discoverPhotos() as $photo) {
            $cat = JoueurPhotoImport::normalizeCategory($photo['categorie']);
            $key = $cat.'|'.JoueurPhotoFilename::normalizeKey($photo['prenom'], $photo['nom']);
            $map[$key] = $photo;
        }

        return $map;
    }

    /**
     * @param  list<string>  $categories
     * @param  list<array<string, mixed>>  $joueurs
     */
    private function mergeSeniorGoalkeepersFromPhotos(array &$categories, array &$joueurs): void
    {
        $dir = database_path(JoueurPhotoImport::PHOTOS_ROOT.'/Senior');
        if (! is_dir($dir)) {
            return;
        }

        if (! in_array('Senior', $categories, true)) {
            $categories[] = 'Senior';
        }

        $joueurs = array_values(array_filter(
            $joueurs,
            fn (array $row) => ($row['categorie'] ?? '') !== 'Senior'
        ));

        foreach (File::files($dir) as $file) {
            $parsed = JoueurPhotoFilename::parse($file->getFilename());
            if ($parsed === null || $parsed['poste'] !== 'Gardien') {
                continue;
            }

            $joueurs[] = [
                'nom' => $parsed['nom'],
                'prenom' => $parsed['prenom'],
                'poste' => 'Gardien',
                'categorie' => 'Senior',
            ];
        }
    }

    /**
     * @param  array<string, mixed>  $row
     * @param  array<string, array{categorie: string, prenom: string, nom: string, poste: string|null, source: string, filename: string}>  $photoByPlayer
     */
    private function resolveJoueurPhoto(array $row, string $categorie, array $photoByPlayer): ?string
    {
        $key = $categorie.'|'.JoueurPhotoFilename::normalizeKey((string) $row['prenom'], (string) $row['nom']);
        $photo = $photoByPlayer[$key] ?? null;

        if ($photo === null && isset($row['photo_file']) && is_string($row['photo_file'])) {
            $fallback = database_path(JoueurPhotoImport::PHOTOS_ROOT.'/'.$categorie.'/'.$row['photo_file']);
            if (is_file($fallback)) {
                $photo = [
                    'categorie' => $categorie,
                    'prenom' => (string) $row['prenom'],
                    'nom' => (string) $row['nom'],
                    'poste' => null,
                    'source' => $fallback,
                    'filename' => $row['photo_file'],
                ];
            }
        }

        if ($photo === null) {
            return null;
        }

        return JoueurPhotoImport::publishPhoto(
            $photo['source'],
            $photo['prenom'],
            $photo['nom'],
            $photo['filename']
        );
    }
}
