<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(6),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'image' => null,
            'restaurant_id' => Restaurant::factory(),
        ];
    }
}
