<?php

namespace Database\Factories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryDestination>
 */
class DeliveryDestinationFactory extends Factory
{
    use RefreshDatabase;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => 1,
            'user_id' => 1,
            'delivery_destination_name' => '自宅',
            'zipcode' => 1234567,
            'address' => fake()->address(),
            'telephone' => 0441234567
        ];
    }
}
