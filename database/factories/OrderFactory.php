<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Order> */
class OrderFactory extends Factory
{
    /** @var class-string<Order> */
    protected $model = Order::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(
                array: OrderStatus::cases(),
            ),
            'user_id' => User::factory(),
            'started_cooking_at' => null,
            'completed_at' => null,
            'cancelled_at' => null,
        ];
    }
}
