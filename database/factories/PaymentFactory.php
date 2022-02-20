<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class PaymentFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $type = $this->faker->randomElement(['credit_card', 'cash_on_delivery', 'bank_transfer']);
        $detail = $this->details($type);

        return [
            'uuid' => Str::orderedUuid(),
            'type' => $type,
            'details' => json_encode($detail)
        ];
    }

    private function details($type)
    {
        $credit_card = [
            "holder_name" => $this->faker->name(),
            "number" =>  $this->faker->randomNumber(3, 10),
            "ccv" => $this->faker->randomNumber(3, 10),
            "expire_date" =>  $this->faker->dateTimeBetween('now', '+3 years')
        ];

        $delivery = [
            "first_name" => $this->faker->name(),
            "last_name" =>  $this->faker->name(),
            "address" =>  $this->faker->address()
        ];

        $bank_transfer = [
            "swift" =>   $this->faker->randomNumber(3, 10),
            "iban" =>   $this->faker->randomNumber(3, 10),
            "name" =>  $this->faker->name()
        ];

        switch ($type) {
            case 'credit_card':
                return  $credit_card;
                break;
            case 'cash_on_delivery':
                return  $delivery;
            case 'bank_transfer':
                return  $bank_transfer;
            default:
                return $credit_card;
        }
    }
}
