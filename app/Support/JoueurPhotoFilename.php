<?php

namespace App\Support;

final class JoueurPhotoFilename
{
    /**
     * Parse player photo names:
     * - G-Abou-Manga-Diop.jpg → gardien
     * - Moussa-Coly.jpg → poste unknown (filled from roster when matching)
     *
     * @return array{prenom: string, nom: string, poste: string|null}|null
     */
    public static function parse(string $filename): ?array
    {
        $base = pathinfo($filename, PATHINFO_FILENAME);
        $poste = null;
        $namePart = $base;

        if (preg_match('/^G-(.+)$/i', $base, $matches)) {
            $poste = 'Gardien';
            $namePart = $matches[1];
        }

        $parts = array_values(array_filter(explode('-', $namePart), fn ($p) => $p !== ''));
        if (count($parts) < 2) {
            return null;
        }

        $nom = array_pop($parts);
        $prenom = implode(' ', $parts);

        return [
            'prenom' => self::titleCase($prenom),
            'nom' => mb_strtoupper($nom),
            'poste' => $poste,
        ];
    }

    public static function normalizeKey(string $prenom, string $nom): string
    {
        $p = mb_strtolower(trim(preg_replace('/\s+/', ' ', $prenom) ?? $prenom));
        $n = mb_strtolower(trim($nom));

        return $p.'|'.$n;
    }

    private static function titleCase(string $value): string
    {
        return mb_convert_case(mb_strtolower(trim($value)), MB_CASE_TITLE, 'UTF-8');
    }
}
