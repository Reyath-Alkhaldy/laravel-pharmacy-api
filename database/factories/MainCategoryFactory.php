<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MainCategory>
 */
class MainCategoryFactory extends Factory
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
        $name_en = $fakr->company;
        $name_ar = $fakr->company;
        // 'name_ar', 'name_en', 'image','pharmacy_id'
        $pharmacy = Pharmacy::inRandomOrder()->first();
        return [
            'name_en' =>  $name_en,
            'name_ar' =>  $name_ar,
            'image' => $this->faker->imageUrl(600, 600),
            'pharmacy_id' => $pharmacy->id,
        ];
    }
}
