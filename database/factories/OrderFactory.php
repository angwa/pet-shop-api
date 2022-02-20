<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class OrderFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'order_status_id' => OrderStatus::factory()->create()->id,
            'payment_id' => Payment::factory()->create()->id,
            'uuid' => Str::orderedUuid(),
            'products' =>  json_encode([
                "product" => Product::factory()->create()->uuid,
                "quantity" => $this->faker->randomNumber(1, 100)
            ]),
            'address' => json_encode([
                'billing' => $this->faker->address(),
                'shipping' => $this->faker->address()
            ]),
            'delivery_fee' => $this->faker->randomDigit,
            'amount' => $this->faker->randomDigit,

        ];
    }
}
