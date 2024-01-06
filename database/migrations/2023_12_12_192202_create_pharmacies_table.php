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
            $table->string('username')->unique();
            $table->string('address');
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->string('phone_number')->unique();
            $table->string('image');
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->integer('number_of_view_days')->nullable();
            // id int  NOT NULL AUTO_INCREMENT,
            // address varchar(255)  NOT NULL,
            // city_id int  NOT NULL,
            // logo varchar(200)  NOT NULL,
            // username int  NOT NULL,
            // password varchar(20)  NOT NULL,
            // confirmation_code varchar(10)  NOT NULL,
            // $table->string('latitude_column')->nullable();
            // $table->string('longitude_column')->nullable();
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
