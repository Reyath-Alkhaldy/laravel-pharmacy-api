<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pharmacy>
 */
class PharmacyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakr =  \Faker\Factory::create();
        $fakr->addProvider(new \Bezhanov\Faker\Provider\Commerce($fakr));
        $name_en = $fakr->name;
        //   'name', 'password',  'address', 'number_of_view_days', 'status', 'image', 'phone_number',
        $city = City::inRandomOrder()->first();
        return [
            'name' =>  $name_en,
            'email' => fake()->unique()->safeEmail(),
            'username' =>  $fakr->userName,
            'password' =>   Hash::make('password'),
            'address' => $fakr->address,
            'image' => $this->faker->imageUrl(600, 600),
            'city_id' => $city->id,
            'number_of_view_days' => $this->faker->numberBetween(30, 365),
            'phone_number' => $fakr->phoneNumber,
        ];
    }
}
