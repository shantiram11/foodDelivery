<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'restaurant_id' => Restaurant::factory(),
            'order_number' => Order::generateOrderNumber(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'completed', 'declined', 'cancelled']),
            'payment_method' => $this->faker->randomElement(['cod', 'esewa']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'subtotal' => $this->faker->randomFloat(2, 100, 2000),
            'total_amount' => $this->faker->randomFloat(2, 100, 2000),
            'customer_phone' => $this->faker->numerify('98########'),
            'delivery_staff_id' => null,
        ];
    }
}
