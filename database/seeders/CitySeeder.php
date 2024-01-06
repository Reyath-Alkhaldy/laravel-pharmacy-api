<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $myContries =  Config::get('my_contries');
        foreach($myContries as $key => $value){
            City::insert([
                'zip_code' => $key,
                'name' => $value,
            ]);
        }
    }
}
