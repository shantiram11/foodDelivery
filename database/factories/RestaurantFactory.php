<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    protected $model = Restaurant::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->sentence(8),
            'address' => $this->faker->address(),
            'phone' => $this->faker->numerify('98########'),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => 'active',
            'rating' => $this->faker->randomFloat(1, 3, 5),
            'image' => null,
        ];
    }
}
