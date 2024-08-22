<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pit>
 */
class PitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titolo' => fake() -> sentence(3),
            'immagine'=>fake()->imageUrl(640, 480, 'projects', true),
            'descrizione' => fake() -> paragraph(),
            'note' => fake() -> paragraph(),
            'visitato' => fake() -> boolean(),
        ];
    }
}
