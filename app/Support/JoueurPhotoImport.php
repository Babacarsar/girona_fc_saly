<?php

namespace App\Support;

use Cloudinary\Api\Exception\ApiError;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\File;

final class JoueurPhotoImport
{
    public const PHOTOS_ROOT = 'seeders/data/joueur_photos';

    /** @var list<string> */
    public const CATEGORY_DIRS = ['U13', 'U15', 'U17', 'U19', 'Senior'];

    /**
     * @return list<array{categorie: string, prenom: string, nom: string, poste: string|null, source: string, filename: string}>
     */
    public static function discoverPhotos(): array
    {
        $items = [];

        foreach (self::CATEGORY_DIRS as $categorie) {
            $dir = database_path(self::PHOTOS_ROOT.'/'.$categorie);
            if (! is_dir($dir)) {
                continue;
            }

            foreach (File::files($dir) as $file) {
                $parsed = JoueurPhotoFilename::parse($file->getFilename());
                if ($parsed === null) {
                    continue;
                }

                $items[] = [
                    'categorie' => $categorie,
                    'prenom' => $parsed['prenom'],
                    'nom' => $parsed['nom'],
                    'poste' => $parsed['poste'],
                    'source' => $file->getPathname(),
                    'filename' => $file->getFilename(),
                ];
            }
        }

        $manifestPath = database_path(self::PHOTOS_ROOT.'/legacy_manifest.json');
        if (is_file($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true, 512, JSON_THROW_ON_ERROR);
            foreach ($manifest as $entry) {
                $file = $entry['file'] ?? null;
                $cat = $entry['categorie'] ?? null;
                if (! is_string($file) || ! is_string($cat)) {
                    continue;
                }
                $source = public_path('upload/joueurs/'.$file);
                if (! is_file($source)) {
                    continue;
                }
                $items[] = [
                    'categorie' => self::normalizeCategory($cat),
                    'prenom' => (string) ($entry['prenom'] ?? ''),
                    'nom' => mb_strtoupper((string) ($entry['nom'] ?? '')),
                    'poste' => $entry['poste'] ?? null,
                    'source' => $source,
                    'filename' => $file,
                ];
            }
        }

        return $items;
    }

    public static function publishPhoto(string $sourcePath, string $prenom, string $nom, string $publicFilename): string
    {
        $destDir = public_path('upload/joueurs');
        File::ensureDirectoryExists($destDir);
        $dest = $destDir.'/'.$publicFilename;
        if (! is_file($dest) || md5_file($dest) !== md5_file($sourcePath)) {
            File::copy($sourcePath, $dest);
        }

        $relative = 'upload/joueurs/'.$publicFilename;

        if (self::cloudinaryConfigured()) {
            try {
                $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $prenom.'_'.$nom));
                $uploaded = Cloudinary::upload($sourcePath, [
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

    public static function normalizeCategory(string $categorie): string
    {
        $c = trim($categorie);
        if (strcasecmp($c, 'Seniors') === 0) {
            return 'Senior';
        }

        return $c;
    }

    private static function cloudinaryConfigured(): bool
    {
        return filled(config('cloudinary.cloud_name'))
            && filled(config('cloudinary.api_key'))
            && filled(config('cloudinary.api_secret'));
    }
}
