<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GrupoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name,
            'descripcion' => fake()->text(500),
            "precio_minimo" => fake()->numberBetween(20, 100),
            "precio_maximo" => fake()->numberBetween(200, 500),
            "tematica_regalos" => fake()->word,
            "administrador" => User::where("email", "amjsoler@gmail.com")->first()->id
        ];
    }
}
