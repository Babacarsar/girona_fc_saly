<?php

namespace Database\Seeders;

use App\Models\StaffTechnique;
use Illuminate\Database\Seeder;

class StaffTechniqueSeeder extends Seeder
{
    public function run(): void
    {
        StaffTechnique::factory()->count(15)->create(); // 15 membres générés aléatoirement
    }
}
