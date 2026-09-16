<?php

namespace Database\Seeders;

use App\Models\Actualite;
use App\Models\Categorie;
use App\Models\Joueur;
use App\Models\Matchs;
use App\Models\Media;
use App\Models\Partenaire;
use App\Models\PreInscription;
use App\Models\StaffTechnique;
use Cloudinary\Api\Exception\ApiError;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class ClubDemoSeeder extends Seeder
{
    /** Remote demo images (Picsum — fetchable from Railway / Cloudinary). */
    private const IMG_FOOTBALL = 'https://picsum.photos/id/1057/800/600';

    private const IMG_STADIUM = 'https://picsum.photos/id/274/800/600';

    private const IMG_TEAM = 'https://picsum.photos/id/433/800/600';

    private const IMG_TRAINING = 'https://picsum.photos/id/1060/800/600';

    private const IMG_BALL = 'https://picsum.photos/id/477/800/600';

    private const IMG_YOUTH = 'https://picsum.photos/id/338/800/600';

    private const IMG_HOTEL = 'https://picsum.photos/id/271/200/200';

    private const IMG_NUTRITION = 'https://picsum.photos/id/292/200/200';

    private const IMG_AUTO = 'https://picsum.photos/id/111/200/200';

    private function cloudinaryConfigured(): bool
    {
        return filled(config('cloudinary.cloud_name'))
            && filled(config('cloudinary.api_key'))
            && filled(config('cloudinary.api_secret'));
    }

    /**
     * @return array{url: string, public_id: string|null}
     */
    private function uploadDemoImage(string $sourceUrl, string $folder, string $publicId): array
    {
        if (! $this->cloudinaryConfigured()) {
            return ['url' => $sourceUrl, 'public_id' => null];
        }

        $tempFile = null;

        try {
            $filePath = $sourceUrl;
            if (str_starts_with($sourceUrl, 'http://') || str_starts_with($sourceUrl, 'https://')) {
                $response = Http::timeout(30)->get($sourceUrl);
                if (! $response->successful()) {
                    return ['url' => $sourceUrl, 'public_id' => null];
                }
                $tempFile = tempnam(sys_get_temp_dir(), 'girona_demo_');
                file_put_contents($tempFile, $response->body());
                $filePath = $tempFile;
            }

            $uploaded = Cloudinary::upload($filePath, [
                'folder' => $folder,
                'public_id' => $publicId,
                'overwrite' => true,
                'resource_type' => 'image',
            ]);

            return [
                'url' => $uploaded->getSecurePath(),
                'public_id' => $uploaded->getPublicId(),
            ];
        } catch (ApiError|\Throwable) {
            return ['url' => $sourceUrl, 'public_id' => null];
        } finally {
            if ($tempFile && is_file($tempFile)) {
                @unlink($tempFile);
            }
        }
    }

    public function run(): void
    {
        $categories = $this->seedCategories();
        $this->seedJoueurs($categories);
        $this->seedStaff($categories);
        $this->seedActualites();
        $this->seedMedia();
        $this->seedMatchs($categories);
        $this->seedPartenaires();
        $this->seedPreInscriptions($categories);
    }

    /**
     * @return array<string, int>
     */
    private function seedCategories(): array
    {
        $names = ['U20', 'U17', 'U15', 'Seniors'];
        $map = [];

        foreach ($names as $nom) {
            $cat = Categorie::firstOrCreate(['nom' => $nom]);
            $map[$nom] = $cat->id;
        }

        return $map;
    }

    /**
     * @param  array<string, int>  $categories
     */
    private function seedJoueurs(array $categories): void
    {
        $roster = [
            'U20' => [
                ['prenom' => 'Amadou', 'nom' => 'Diallo', 'age' => 19, 'poste' => 'Gardien', 'photo' => self::IMG_FOOTBALL],
                ['prenom' => 'Ibrahima', 'nom' => 'Sow', 'age' => 18, 'poste' => 'Défenseur', 'photo' => self::IMG_TEAM],
                ['prenom' => 'Moussa', 'nom' => 'Camara', 'age' => 20, 'poste' => 'Milieu', 'photo' => self::IMG_TRAINING],
                ['prenom' => 'Cheikh', 'nom' => 'Ba', 'age' => 19, 'poste' => 'Attaquant', 'photo' => self::IMG_BALL],
                ['prenom' => 'Pape', 'nom' => 'Ndiaye', 'age' => 18, 'poste' => 'Ailier', 'photo' => self::IMG_YOUTH],
            ],
            'U17' => [
                ['prenom' => 'Landing', 'nom' => 'Diop', 'age' => 16, 'poste' => 'Gardien', 'photo' => self::IMG_FOOTBALL],
                ['prenom' => 'Ousmane', 'nom' => 'Gueye', 'age' => 17, 'poste' => 'Défenseur', 'photo' => self::IMG_TEAM],
                ['prenom' => 'Aliou', 'nom' => 'Mbaye', 'age' => 16, 'poste' => 'Milieu', 'photo' => self::IMG_TRAINING],
                ['prenom' => 'Modou', 'nom' => 'Fall', 'age' => 17, 'poste' => 'Attaquant', 'photo' => self::IMG_BALL],
            ],
            'U15' => [
                ['prenom' => 'Babacar', 'nom' => 'Sarr', 'age' => 14, 'poste' => 'Milieu', 'photo' => self::IMG_YOUTH],
                ['prenom' => 'Mamadou', 'nom' => 'Kane', 'age' => 15, 'poste' => 'Attaquant', 'photo' => self::IMG_TEAM],
            ],
            'Seniors' => [
                ['prenom' => 'Serigne', 'nom' => 'Diouf', 'age' => 24, 'poste' => 'Capitaine', 'photo' => self::IMG_STADIUM],
                ['prenom' => 'Abdou', 'nom' => 'Sy', 'age' => 26, 'poste' => 'Milieu', 'photo' => self::IMG_FOOTBALL],
            ],
        ];

        $ordre = 0;
        foreach ($roster as $catName => $players) {
            $catId = $categories[$catName];
            foreach ($players as $p) {
                $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $p['prenom'].'_'.$p['nom']));
                $photo = $this->uploadDemoImage($p['photo'], 'joueurs_foot', 'demo_'.$slug);

                Joueur::updateOrCreate(
                    [
                        'nom' => $p['nom'],
                        'prenom' => $p['prenom'],
                        'categorie_id' => $catId,
                    ],
                    [
                        'age' => $p['age'],
                        'poste' => $p['poste'],
                        'photo' => $photo['url'],
                        'ordre' => $ordre++,
                    ]
                );
            }
        }
    }

    /**
     * @param  array<string, int>  $categories
     */
    private function seedStaff(array $categories): void
    {
        $members = [
            ['prenom' => 'Babacar', 'nom' => 'Sarr', 'role' => 'Directeur sportif', 'categorie_id' => $categories['Seniors'], 'photo' => self::IMG_STADIUM],
            ['prenom' => 'Mamadou', 'nom' => 'Diop', 'role' => 'Entraîneur U20', 'categorie_id' => $categories['U20'], 'photo' => self::IMG_TRAINING],
            ['prenom' => 'Fatou', 'nom' => 'Ndiaye', 'role' => 'Préparatrice physique', 'categorie_id' => $categories['U17'], 'photo' => self::IMG_TEAM],
            ['prenom' => 'Omar', 'nom' => 'Cissé', 'role' => 'Entraîneur gardiens', 'categorie_id' => $categories['U15'], 'photo' => self::IMG_FOOTBALL],
        ];

        foreach ($members as $m) {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $m['prenom'].'_'.$m['nom']));
            $photo = $this->uploadDemoImage($m['photo'], 'staff_technique', 'demo_'.$slug);
            $payload = $m;
            $payload['photo'] = $photo['url'];

            StaffTechnique::updateOrCreate(
                [
                    'nom' => $m['nom'],
                    'prenom' => $m['prenom'],
                    'categorie_id' => $m['categorie_id'],
                ],
                $payload
            );
        }
    }

    private function seedActualites(): void
    {
        $articles = [
            [
                'titre' => 'Victoire 3-1 en amical contre ASC Yoff',
                'contenu' => '<p>Les <strong>Girona de Saly</strong> ont dominé leur adversaire grâce à un collectif solide.</p><p><img src="'.self::IMG_STADIUM.'" alt="Match amical"></p>',
                'image' => self::IMG_STADIUM,
                'auteur' => 'Com. club',
                'statut' => Actualite::STATUT_PUBLIE,
                'a_la_une' => true,
                'ordre' => 0,
                'date_publication' => Carbon::now()->subDays(2),
            ],
            [
                'titre' => 'Stage intensif U17 à Saly',
                'contenu' => '<p>Une semaine de préparation avec focus technique et cohésion.</p><p><img src="'.self::IMG_TRAINING.'" alt="Entraînement"></p>',
                'image' => self::IMG_TRAINING,
                'auteur' => 'Staff technique',
                'statut' => Actualite::STATUT_PUBLIE,
                'a_la_une' => false,
                'ordre' => 1,
                'date_publication' => Carbon::now()->subDays(5),
            ],
            [
                'titre' => 'Inscriptions saison 2026 — places limitées',
                'contenu' => '<p>Rejoignez le centre de formation : formulaire en ligne disponible.</p>',
                'image' => self::IMG_YOUTH,
                'auteur' => 'Secrétariat',
                'statut' => Actualite::STATUT_PUBLIE,
                'a_la_une' => false,
                'ordre' => 2,
                'date_publication' => Carbon::now()->subDay(),
            ],
            [
                'titre' => 'Brouillon : tournoi interne (non publié)',
                'contenu' => '<p>Article en préparation.</p>',
                'image' => null,
                'auteur' => 'Com. club',
                'statut' => Actualite::STATUT_BROUILLON,
                'a_la_une' => false,
                'ordre' => 3,
                'date_publication' => Carbon::now(),
            ],
        ];

        foreach ($articles as $a) {
            if (! empty($a['image'])) {
                $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $a['titre']));
                $cover = $this->uploadDemoImage($a['image'], 'actualites_foot', 'demo_'.substr($slug, 0, 40));
                $a['image'] = $cover['url'];
                $a['image_public_id'] = $cover['public_id'];
                $a['contenu'] = preg_replace(
                    '#https://picsum\.photos/[^"\']+#',
                    $cover['url'],
                    $a['contenu']
                );
            }

            Actualite::updateOrCreate(['titre' => $a['titre']], $a);
        }
    }

    private function seedMedia(): void
    {
        $items = [
            ['title' => 'Entraînement U20', 'type' => 'image', 'file_path' => self::IMG_TRAINING],
            ['title' => 'Ambiance stade', 'type' => 'image', 'file_path' => self::IMG_STADIUM],
            ['title' => 'Célébration but', 'type' => 'image', 'file_path' => self::IMG_TEAM],
            ['title' => 'Match en cours', 'type' => 'image', 'file_path' => self::IMG_FOOTBALL],
            ['title' => 'Jeunes talents', 'type' => 'image', 'file_path' => self::IMG_YOUTH],
            ['title' => 'Focus ballon', 'type' => 'image', 'file_path' => self::IMG_BALL],
        ];

        foreach ($items as $item) {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $item['title']));
            $uploaded = $this->uploadDemoImage($item['file_path'], 'media_girona', 'demo_'.$slug);
            $item['file_path'] = $uploaded['url'];

            Media::updateOrCreate(['title' => $item['title']], $item);
        }
    }

    /**
     * @param  array<string, int>  $categories
     */
    private function seedMatchs(array $categories): void
    {
        $matchs = [
            [
                'adversaire' => 'ASC Yoff',
                'date_match' => Carbon::now()->subDays(7)->setTime(16, 0),
                'lieu' => 'Stade de Saly',
                'score_domicile' => '3',
                'score_exterieur' => '1',
                'type' => 'amical',
                'categorie_id' => $categories['U20'],
                'notes' => 'Très bon début de saison.',
                'ordre' => 0,
            ],
            [
                'adversaire' => 'Diambars FC',
                'date_match' => Carbon::now()->subDays(14)->setTime(15, 0),
                'lieu' => 'Saly',
                'score_domicile' => '2',
                'score_exterieur' => '2',
                'type' => 'amical',
                'categorie_id' => $categories['U17'],
                'notes' => null,
                'ordre' => 1,
            ],
            [
                'adversaire' => 'Académie Dakar',
                'date_match' => Carbon::now()->addDays(10)->setTime(17, 0),
                'lieu' => 'Stade de Saly',
                'score_domicile' => null,
                'score_exterieur' => null,
                'type' => 'amical',
                'categorie_id' => $categories['U20'],
                'notes' => 'Match de préparation.',
                'ordre' => 2,
            ],
            [
                'adversaire' => 'Tournoi Saly Cup — demi-finale',
                'date_match' => Carbon::now()->addDays(21)->setTime(10, 0),
                'lieu' => 'Complexe Girona',
                'score_domicile' => null,
                'score_exterieur' => null,
                'type' => 'tournoi',
                'categorie_id' => $categories['U15'],
                'notes' => 'Horaire à confirmer.',
                'ordre' => 3,
            ],
        ];

        foreach ($matchs as $m) {
            Matchs::firstOrCreate(
                [
                    'adversaire' => $m['adversaire'],
                    'date_match' => $m['date_match'],
                ],
                $m
            );
        }
    }

    private function seedPartenaires(): void
    {
        $partners = [
            [
                'nom' => 'Saly Resort',
                'logo' => self::IMG_HOTEL,
                'description' => 'Partenaire hébergement & événements',
                'url' => 'https://example.com/saly-resort',
                'ordre' => 0,
                'actif' => true,
            ],
            [
                'nom' => 'Sport Nutrition SN',
                'logo' => self::IMG_NUTRITION,
                'description' => 'Nutrition des équipes jeunes',
                'url' => 'https://example.com/nutrition',
                'ordre' => 1,
                'actif' => true,
            ],
            [
                'nom' => 'Girona FC',
                'logo' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f2/Girona_FC_Logo.svg/120px-Girona_FC_Logo.svg.png',
                'description' => 'Club partenaire international',
                'url' => 'https://www.girona-fc.com/',
                'ordre' => 2,
                'actif' => true,
            ],
            [
                'nom' => 'Local Auto Saly',
                'logo' => self::IMG_AUTO,
                'description' => 'Mobilité du club',
                'url' => null,
                'ordre' => 3,
                'actif' => true,
            ],
        ];

        foreach ($partners as $p) {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $p['nom']));
            $logo = $this->uploadDemoImage($p['logo'], 'partenaires_logos', 'demo_'.$slug);
            $p['logo'] = $logo['url'];

            Partenaire::updateOrCreate(['nom' => $p['nom']], $p);
        }
    }

    /**
     * @param  array<string, int>  $categories
     */
    private function seedPreInscriptions(array $categories): void
    {
        PreInscription::firstOrCreate(
            ['email_parent' => 'parent.fall@example.com', 'nom' => 'Fall', 'prenom' => 'Khady'],
            [
            'prenom' => 'Khady',
            'nom' => 'Fall',
            'date_naissance' => '2011-03-12',
            'categorie_id' => $categories['U15'],
            'email_parent' => 'parent.fall@example.com',
            'telephone' => '+221771234567',
            'message' => 'Joueur gaucher, poste milieu.',
            'traite' => false,
            ]
        );

        PreInscription::firstOrCreate(
            ['email_parent' => 'jean.dupont.parent@example.com', 'nom' => 'Dupont', 'prenom' => 'Jean'],
            [
                'date_naissance' => '2009-08-01',
                'categorie_id' => $categories['U17'],
                'telephone' => '+221701112233',
                'message' => null,
                'traite' => true,
            ]
        );
    }
}
