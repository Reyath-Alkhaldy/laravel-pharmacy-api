<?php

namespace Database\Factories;

use App\Models\MainCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategory>
 */
class SubCategoryFactory extends Factory
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
        $name_en = $fakr->city;
        $name_ar = $fakr->city;
        // 'name_ar', 'name_en', 'image', 'main_category_id',
        $mainCategory = MainCategory::inRandomOrder()->first();
        return [
            'name_en' =>  $name_en,
            'name_ar' =>  $name_ar,
            'image' => $this->faker->imageUrl(600, 600),
            'main_category_id' => $mainCategory->id,
        ];
    }
}
