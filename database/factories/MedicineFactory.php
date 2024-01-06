<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
// use Faker\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
    $fakr =  \Faker\Factory::create();
    $fakr->addProvider(new \Bezhanov\Faker\Provider\Medicine($fakr));
        $name_en = $fakr->name;
        $name_ar = $fakr->name;
        // 'name_en', 'name_ar',  'image', 'price','count', 'status', 'description' ,'sub_category_id','pharmacy_id'
        return [ 
        'name_en' =>  $name_en,
        'name_ar' =>  $name_ar,
        'scien_name' =>  $fakr->firstName,
        'mark_name' =>  $fakr->lastName,
        'description' => fake()->sentence(10),
        'image' => $this->faker->imageUrl(600,600) ,
        'price' => $this->faker->randomFloat(2,1,500) ,
        'discount' => $this->faker->randomFloat(2,1,100) ,
        // 'compare_price' => $this->faker->randomFloat(2,500,999) ,
        'count' => $this->faker->numberBetween(50,200),
        'sub_category_id' => SubCategory::inRandomOrder()->first()->id ,
        'pharmacy_id' => Pharmacy::inRandomOrder()->first()->id ,
    ];
    }
}
