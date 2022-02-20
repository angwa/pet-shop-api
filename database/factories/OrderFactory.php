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
        $amount = $this->faker->randomFloat(2, 0, 10000);
        $fee = ($amount > 500) ? 0 : 15;

        $orderId = OrderStatus::factory()->create()->id;
        $status = OrderStatus::find($orderId);

        $paymentId = ($status->title === 'paid' || $status->title === 'shipped') ? Payment::factory()->create()->id : null;
        $shipped_at = ($status->title === 'shipped') ? $status->updated_at : null;

        return [
            'user_id' => User::all()->random()->id,
            'order_status_id' => $orderId,
            'payment_id' => $paymentId,
            'uuid' => Str::orderedUuid(),
            'products' =>  json_encode([
                "product" => Product::all()->random()->uuid,
                "quantity" => $this->faker->randomNumber(1, 100)
            ]),
            'address' => json_encode([
                'billing' => $this->faker->address(),
                'shipping' => $this->faker->address()
            ]),
            'delivery_fee' => $fee,
            'amount' => $amount,
            'shipped_at' =>  $shipped_at,
        ];
    }
}
