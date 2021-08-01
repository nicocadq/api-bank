<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->text(),
            'amount' => $this->faker->numberBetween($min = 10, $max = 20),
            'origin_wallet_id' =>  $this->faker->randomDigitNotNull;
            'destiny_wallet_id' => $this->faker->randomDigit;
        ];
    }
}
