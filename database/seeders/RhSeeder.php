<?php

namespace Database\Seeders;

use App\Models\Conge;
use App\Models\Departement;
use App\Models\Employe;
use Illuminate\Database\Seeder;

class RhSeeder extends Seeder
{
    public function run(): void
    {
        $departements = Departement::factory(5)->create();

        $departements->each(function (Departement $d) {
            Employe::factory(rand(3, 6))->for($d)->create()->each(function (Employe $e) {
                Conge::factory(rand(0, 2))->for($e)->create();
            });
        });
    }
}
