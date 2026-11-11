<?php

namespace Database\Factories;

use App\Models\Conge;
use App\Models\Employe;
use Illuminate\Database\Eloquent\Factories\Factory;

class CongeFactory extends Factory
{
    public function definition(): array
    {
        $debut = fake()->dateTimeBetween('-2 months', '+2 months');

        return [
            'employe_id' => Employe::factory(),
            'type' => fake()->randomElement(array_keys(Conge::TYPES)),
            'date_debut' => $debut,
            'date_fin' => (clone $debut)->modify('+'.fake()->numberBetween(0, 6).' days'),
            'motif' => fake()->optional()->sentence(),
            'statut' => fake()->randomElement(array_keys(Conge::STATUTS)),
        ];
    }
}
