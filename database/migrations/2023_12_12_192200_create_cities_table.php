<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // id int  NOT NULL AUTO_INCREMENT,
    // city_name varchar(255)  NOT NULL,
    // zip_code varchar(16)  NOT NULL,
    // CONSTRAINT city_pk PRIMARY KEY (id)
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
        $table->string('name');
            $table->string('zip_code',16);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
