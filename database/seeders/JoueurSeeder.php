<?php

namespace Database\Seeders;

use App\Models\Joueur;
use App\Models\Categorie;
use Illuminate\Database\Seeder;

class JoueurSeeder extends Seeder
{
    public function run(): void
    {
        // Récupère ou crée la catégorie "Senior"
        $categorie = Categorie::firstOrCreate(['nom' => 'Senior']);

        // Exemple de 5 joueurs fictifs
        $joueurs = [
            ['nom' => 'Diallo', 'prenom' => 'Moussa', 'age' => 24, 'poste' => 'Défenseur', 'photo' => 'upload/joueurs/moussa.jpg'],
            ['nom' => 'Fall', 'prenom' => 'Amadou', 'age' => 22, 'poste' => 'Attaquant', 'photo' => 'upload/joueurs/amadou.jpg'],
            ['nom' => 'Sarr', 'prenom' => 'Ibrahima', 'age' => 25, 'poste' => 'Milieu', 'photo' => 'upload/joueurs/ibrahima.jpg'],
            ['nom' => 'Ndoye', 'prenom' => 'Cheikh', 'age' => 23, 'poste' => 'Gardien', 'photo' => 'upload/joueurs/cheikh.jpg'],
            ['nom' => 'Diop', 'prenom' => 'Alioune', 'age' => 21, 'poste' => 'Défenseur', 'photo' => 'upload/joueurs/alioune.jpg'],
        ];

        foreach ($joueurs as $joueur) {
            Joueur::create(array_merge($joueur, [
                'categorie_id' => $categorie->id
            ]));
        }
    }
}
