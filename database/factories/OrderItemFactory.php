<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<OrderItem> */
class OrderItemFactory extends Factory
{
    /** @var class-string<OrderItem> */
    protected $model = OrderItem::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(
                array: [
                    'chips',
                    'burger',
                    'chicken',
                    'pizza',
                    'ice cream',
                    'fries',
                    'salad',
                    'soda',
                    'coke',
                    'sprite',
                ],
            ),
            'quantity' => $this->faker->numberBetween(1, 10),
            'order_id' => Order::factory(),
        ];
    }
}
