<?php

namespace Tests\Unit;

use App\Support\JoueurPhotoFilename;
use PHPUnit\Framework\TestCase;

class JoueurPhotoFilenameTest extends TestCase
{
    public function test_parses_goalkeeper_filename_with_multi_part_first_name(): void
    {
        $parsed = JoueurPhotoFilename::parse('G-Abou-Manga-Diop.jpg');

        $this->assertSame('Abou Manga', $parsed['prenom']);
        $this->assertSame('DIOP', $parsed['nom']);
        $this->assertSame('Gardien', $parsed['poste']);
    }

    public function test_ignores_non_goalkeeper_filenames(): void
    {
        $this->assertNull(JoueurPhotoFilename::parse('M-Pape-Sow.png'));
    }
}
