<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\StaffTechnique;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffTechniqueFactory extends Factory
{
    protected $model = StaffTechnique::class;

    public function definition(): array
    {
        // Récupère ou crée une catégorie aléatoire parmi les 5
        $categorie = Categorie::firstOrCreate([
            'nom' => $this->faker->randomElement(['Senior', 'U20', 'U17', 'U15', 'U13']),
        ]);

        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'role' => $this->faker->randomElement(['Entraîneur', 'Entraîneur adjoint']),
            'categorie_id' => $categorie->id,
            'photo' => 'upload/staff/' . $this->faker->image('public/upload/staff', 300, 300, null, false)
        ];
    }
}
