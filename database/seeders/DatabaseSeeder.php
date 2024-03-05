<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\City;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\MainCategory;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Specialty;
use App\Models\SubCategory;
use App\Models\User;
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

        Admin::factory(10)->create();

        Specialty::factory(5)->create();
        User::factory(10)->create();
        Doctor::factory(10)->create();
        Consultation::factory(100)->create();

        // City
        $this->call([
            CitySeeder::class,
        ]);
        Pharmacy::factory(10)->create();
        MainCategory::factory(10)->create();
        SubCategory::factory(20)->create();
        Medicine::factory(2000)->create();
    }
}
