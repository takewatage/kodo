<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::all()->first();

        return [
            'id' => $this->faker->uuid(),
            'name' => fake()->name(),
            'code' => fake()->unique()->password(10),
            'owner_id' => $user->id,
        ];
    }
}
