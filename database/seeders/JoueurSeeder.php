<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Joueur;
use App\Models\Categorie;

class JoueurSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'U20' => [
                ['prenom' => 'MOUHAMED', 'nom' => 'KOUNTA', 'annee' => 2005],
                ['prenom' => 'IBRAHIMA', 'nom' => 'NIANG', 'annee' => 2005],
                ['prenom' => 'PAPA SIDI BOUYA', 'nom' => 'DIOUF', 'annee' => 2007],
                ['prenom' => 'SINY', 'nom' => 'SENE', 'annee' => 2005],
                ['prenom' => 'MAMADOU LAMINE', 'nom' => 'BA', 'annee' => 2008],
                ['prenom' => 'MOHAMED', 'nom' => 'NGOM', 'annee' => 2008],
                ['prenom' => 'BECAYE', 'nom' => 'GUEYE', 'annee' => 2009],
                ['prenom' => 'DEMBA', 'nom' => 'GUEYE', 'annee' => 2009],
                ['prenom' => 'MOUSTAPHA', 'nom' => 'GUEYE', 'annee' => 2008],
                ['prenom' => 'MAURICE', 'nom' => 'KAMA', 'annee' => 2006],
                ['prenom' => 'DJIBY', 'nom' => 'LAM', 'annee' => 2006],
                ['prenom' => 'CHEIKHOU', 'nom' => 'GUEYE', 'annee' => 2006],
                ['prenom' => 'ALPHA', 'nom' => 'SOW', 'annee' => 2006],
                ['prenom' => 'ELHADJI ABLAYE', 'nom' => 'SENE', 'annee' => 2006],
                ['prenom' => 'CHEIKHOU', 'nom' => 'GOUDIABY', 'annee' => 2007],
                ['prenom' => 'SERIGNE FALLOU', 'nom' => 'SOW', 'annee' => 2006],
                ['prenom' => 'SEEDY', 'nom' => 'NJIE', 'annee' => 2006],
                ['prenom' => 'SOULEYMANE KANE', 'nom' => 'DIOP', 'annee' => 2005],
                ['prenom' => 'ABIBOU', 'nom' => 'SAMB', 'annee' => 2007],
                ['prenom' => 'PROSPER', 'nom' => 'NADLIEN', 'annee' => 2010],
                ['prenom' => 'CHEIKH ADRAME', 'nom' => 'SOW', 'annee' => 2009],
                ['prenom' => 'IBRAHIMA', 'nom' => 'NDOUR', 'annee' => 2007],
                ['prenom' => 'ELHADJI LAMINE', 'nom' => 'DIOUF', 'annee' => 2007],
                ['prenom' => 'IBRAHIMA', 'nom' => 'SENE', 'annee' => 2006],
                ['prenom' => 'NDIOGOU', 'nom' => 'NDIAYE', 'annee' => 2006],
                ['prenom' => 'ELHADJI IBRAHIMA', 'nom' => 'NIANG', 'annee' => 2007],
                ['prenom' => 'MOUHAMED DAME', 'nom' => 'NIASSY', 'annee' => 2009],
            ],
            'U17' => [
                ['prenom' => 'THIRNO YAYA', 'nom' => 'BA', 'annee' => 2010],
                ['prenom' => 'ELHADJI BABA', 'nom' => 'DIOUF', 'annee' => 2009],
                ['prenom' => 'SEYDOU MOUHAMED', 'nom' => 'BA', 'annee' => 2011],
                ['prenom' => 'MAMADOU DIOUF', 'nom' => 'DIAGNE', 'annee' => 2009],
                ['prenom' => 'BOUBACAR LILA', 'nom' => 'SAKHO', 'annee' => 2008],
                ['prenom' => 'OMAR', 'nom' => 'DIATTA', 'annee' => 2008],
                ['prenom' => 'ALY', 'nom' => 'NDIAYE', 'annee' => 2010],
                ['prenom' => 'ALIOUNE', 'nom' => 'SECK', 'annee' => 2009],
                ['prenom' => 'ASSANE', 'nom' => 'NIANG', 'annee' => 2009],
                ['prenom' => 'SENY', 'nom' => 'MANE', 'annee' => 2010],
                ['prenom' => 'OUSMANE', 'nom' => 'NDIAYE', 'annee' => 2011],
                ['prenom' => 'OUSMANE', 'nom' => 'GUEYE', 'annee' => 2011],
                ['prenom' => 'PAPA SANA', 'nom' => 'DIEDHIOU', 'annee' => 2010],
                ['prenom' => 'CHEIKH MBACKE', 'nom' => 'GADIAGA', 'annee' => 2011],
                ['prenom' => 'OUSMANE', 'nom' => 'TAMBA', 'annee' => 2010],
                ['prenom' => 'MAME MOR', 'nom' => 'GUEYE', 'annee' => 2010],
                ['prenom' => 'MOUHAMED FADEL', 'nom' => 'CONDE', 'annee' => 2008],
                ['prenom' => 'KEBA', 'nom' => 'MANE', 'annee' => 2009],
                ['prenom' => 'AMIDOU', 'nom' => 'SAGNA', 'annee' => 2008],
                ['prenom' => 'LAMINE', 'nom' => 'SENE', 'annee' => 2010],
                ['prenom' => 'FALLOU', 'nom' => 'DIOP', 'annee' => 2010],
                ['prenom' => 'DOUFY', 'nom' => 'TINE', 'annee' => 2010],
                ['prenom' => 'PAPE FASAR', 'nom' => 'DIOP', 'annee' => 2010],
                ['prenom' => 'KHADIM BAMBA', 'nom' => 'NDOYE', 'annee' => 2010],
                ['prenom' => 'LANDING', 'nom' => 'BIAGUI', 'annee' => 2010],
                ['prenom' => 'SERIGNE MODOU', 'nom' => 'KANE', 'annee' => 2009],
                ['prenom' => 'PAPE IBRAHIMA', 'nom' => 'KANDJI', 'annee' => 2009],
            ]
        ];

        foreach ($categories as $nomCategorie => $joueurs) {
            $categorieId = Categorie::where('nom', $nomCategorie)->value('id');

            foreach ($joueurs as $joueur) {
                Joueur::create([
                    'nom' => $joueur['nom'],
                    'prenom' => $joueur['prenom'],
                    'age' => now()->year - $joueur['annee'],
                    'poste' => 'Inconnu',
                    'categorie_id' => $categorieId,
                    'photo' => 'default.jpg',
                ]);
            }
        }
    }
}
