<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $uuid = $this->faker->uuid();

        return [
            'code' => $uuid,
            'short_code' => "S2025" . substr($uuid, 0, 6),
            'name' => fake()->name,
            'description' => fake()->text(500)
        ];
    }
}
