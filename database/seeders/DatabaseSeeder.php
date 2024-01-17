<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\City;
use App\Models\MainCategory;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // City
        // $this->call([
        //     CitySeeder::class,
        // ]);
        // Pharmacy::factory(10)->create();
        // MainCategory::factory(10)->create();
        // SubCategory::factory(20)->create();
        Medicine::factory(40)->create();
    }
}
