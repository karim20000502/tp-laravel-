<?php

namespace Database\Factories;

use App\Models\Departement;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeFactory extends Factory
{
    public function definition(): array
    {
        $genre = fake()->randomElement(['H', 'F']);

        return [
            'matricule' => 'EMP'.fake()->unique()->numerify('####'),
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName($genre === 'H' ? 'male' : 'female'),
            'cin' => strtoupper(fake()->unique()->bothify('??######')),
            'email' => fake()->unique()->safeEmail(),
            'telephone' => fake()->numerify('06########'),
            'genre' => $genre,
            'date_naissance' => fake()->dateTimeBetween('-55 years', '-22 years'),
            'date_embauche' => fake()->dateTimeBetween('-10 years', 'now'),
            'poste' => fake()->randomElement(['Assistant', 'Technicien', 'Ingénieur', 'Chef de projet', 'Comptable', 'Commercial', 'Responsable']),
            'salaire' => fake()->numberBetween(4000, 25000),
            'statut' => 'actif',
            'departement_id' => Departement::factory(),
        ];
    }
}
