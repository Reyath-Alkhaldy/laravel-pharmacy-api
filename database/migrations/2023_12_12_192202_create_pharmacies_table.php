<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
//   final String id;
//   final String name;
//   final String password;
//   final String logUrl;
//   final String address;
//   final List<String>? phoneNumbers;
//   final List<String> location;
//   final int numberOfViewDays;
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->string('address');
            $table->string('phone_number')->unique();
            $table->string('image');
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->string('number_of_view_days')->nullable();
            $table->string('latitude_column')->nullable();
            $table->string('longitude_column')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
