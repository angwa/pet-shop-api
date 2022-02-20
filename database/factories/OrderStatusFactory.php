<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class OrderStatusFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderStatus::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = $this->faker->randomElement(['open', 'pending_payment', 'paid', 'shipped', 'cancelled']);
        
        return [
            'uuid' => Str::orderedUuid(),
            'title' => $status,
        ];
    }
}
