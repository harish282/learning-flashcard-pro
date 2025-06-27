<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deck>
 */
class DeckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Automatically creates a user
            'name' => $this->faker->unique()->words(3, true), // e.g., "Laravel Flash Cards"
            'is_public' => $this->faker->boolean(70), // 70% chance to be public
        ];
    }
}
