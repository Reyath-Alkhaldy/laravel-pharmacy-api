<?php

namespace Database\Factories;

use App\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakr =  \Faker\Factory::create();
        // $fakr->addProvider(new \Bezhanov\Faker\Provider\Commerce($fakr));
        $specialty = Specialty::inRandomOrder()->first();
        return [
            'name' =>  $fakr->name,
            'email' =>   $fakr->email,
            'password' =>   Hash::make('password'),
            'image' => $fakr->imageUrl(600, 600),
            'specialty_id' => $specialty->id,
        ];
    }
}
