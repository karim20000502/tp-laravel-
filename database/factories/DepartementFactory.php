<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->randomElement([
                'Ressources Humaines', 'Informatique', 'Comptabilité', 'Commercial',
                'Marketing', 'Logistique', 'Production', 'Juridique',
            ]),
            'description' => fake()->sentence(),
        ];
    }
}
