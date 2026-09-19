<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Joueur;
use App\Models\Matchs;
use App\Models\PreInscription;
use App\Models\StaffTechnique;
use App\Support\JoueurPhotoFilename;
use Cloudinary\Api\Exception\ApiError;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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

    private const SENIOR_PHOTOS_DIR = 'seeders/data/joueur_photos/Senior';

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
                $photo = $this->resolveJoueurPhoto($row, $catNom);

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
     * @param  list<string>  $categories
     * @param  list<array<string, mixed>>  $joueurs
     */
    private function mergeSeniorGoalkeepersFromPhotos(array &$categories, array &$joueurs): void
    {
        $dir = database_path(self::SENIOR_PHOTOS_DIR);
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
            if ($parsed === null) {
                continue;
            }

            $joueurs[] = [
                'nom' => $parsed['nom'],
                'prenom' => $parsed['prenom'],
                'poste' => $parsed['poste'],
                'categorie' => 'Senior',
                'photo_file' => $file->getFilename(),
            ];
        }
    }

    /**
     * @param  array<string, mixed>  $row
     */
    private function resolveJoueurPhoto(array $row, string $categorie): ?string
    {
        $photoFile = $row['photo_file'] ?? null;
        if (! is_string($photoFile) || $photoFile === '') {
            return null;
        }

        $source = database_path(self::SENIOR_PHOTOS_DIR.'/'.$photoFile);
        if (! is_file($source)) {
            return null;
        }

        $publicName = $photoFile;
        $destDir = public_path('upload/joueurs');
        File::ensureDirectoryExists($destDir);
        File::copy($source, $destDir.'/'.$publicName);

        $relative = 'upload/joueurs/'.$publicName;

        if ($this->cloudinaryConfigured()) {
            try {
                $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $row['prenom'].'_'.$row['nom']));
                $uploaded = Cloudinary::upload($source, [
                    'folder' => 'joueurs_foot',
                    'public_id' => 'roster_'.$slug,
                    'overwrite' => true,
                    'resource_type' => 'image',
                ]);

                return $uploaded->getSecurePath();
            } catch (ApiError|\Throwable) {
                return $relative;
            }
        }

        return $relative;
    }

    private function cloudinaryConfigured(): bool
    {
        return filled(config('cloudinary.cloud_name'))
            && filled(config('cloudinary.api_key'))
            && filled(config('cloudinary.api_secret'));
    }
}
