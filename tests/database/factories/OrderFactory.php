<?php

namespace Soap\WorkflowStorage\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Soap\WorkflowStorage\Tests\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'name' => 'Order #'.$this->faker->unique()->numberBetween(1, 100),
            'price' => $this->faker->numberBetween(1000, 100000),
            'state' => 'pending',
        ];
    }

    public function forUser(int|User $user)
    {
        $userId = is_object($user) ? $user->id : $user;

        return $this->state(function (array $attributes) {
            return [
                'user_id' => $userId,
            ];
        });
    }
}
