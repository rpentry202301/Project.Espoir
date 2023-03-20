<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryDestination>
 */
class DeliveryDestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'delivery_destination_name' => $faker->word(),
            'zipcode' => $faker->postcode(),
            'address' => $faker->address(),
            'telephone' => $faker->phoneNumber()
        ];
    }
}
