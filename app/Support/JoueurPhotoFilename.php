<?php

namespace App\Support;

final class JoueurPhotoFilename
{
    /**
     * Parse player photo names such as G-Abou-Manga-Diop.jpg (G = gardien).
     *
     * @return array{prenom: string, nom: string, poste: string}|null
     */
    public static function parse(string $filename): ?array
    {
        $base = pathinfo($filename, PATHINFO_FILENAME);
        if (! preg_match('/^G-(.+)$/i', $base, $matches)) {
            return null;
        }

        $parts = array_values(array_filter(explode('-', $matches[1]), fn ($p) => $p !== ''));
        if (count($parts) < 2) {
            return null;
        }

        $nom = array_pop($parts);
        $prenom = implode(' ', $parts);

        return [
            'prenom' => self::titleCase($prenom),
            'nom' => mb_strtoupper($nom),
            'poste' => 'Gardien',
        ];
    }

    private static function titleCase(string $value): string
    {
        return mb_convert_case(mb_strtolower(trim($value)), MB_CASE_TITLE, 'UTF-8');
    }
}
