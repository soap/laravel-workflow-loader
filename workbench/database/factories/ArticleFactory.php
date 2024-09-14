<?php

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
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
