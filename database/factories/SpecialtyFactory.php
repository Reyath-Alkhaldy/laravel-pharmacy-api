<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialty>
 */
class SpecialtyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakr =  \Faker\Factory::create();
        $fakr->addProvider(new \Bezhanov\Faker\Provider\Space($fakr));
        $name = $fakr->name;
        return [
            'name' => $name,
            'image' => $this->faker->imageUrl(600, 600),
        ];
    }
}
