<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'phone_number' => fake()->unique()->phoneNumber(),
            'super_admin' => fake()->randomNumber(1),
        ];
        // $table->string('name');
        // $table->string('email')->unique();
        // $table->string('username')->unique();
        // $table->string('password');
        // $table->string('phone_number')->unique();
        // $table->boolean('super_admin')->default(false);
    }
}
