<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // did int  NOT NULL,
    // dname varchar(100)  NOT NULL,
    // contactphone int  NOT NULL,
    // email varchar(40)  NOT NULL,
    // password varchar(20)  NOT NULL,
    // confirmcode varchar(100)  NOT NULL,
    // jondate timestamp  NOT NULL,
    // logo varchar(30)  NOT NULL,
    // CONSTRAINT doctor_pk PRIMARY KEY (did)
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('image')->nullable();
            $table->foreignId('specialty_id')->nullable()->constrained('specialties')->nullOnDelete();
            $table->enum('status',['active','inactive'])->default('active');
            $table->text('cv')->nullable();
            $table->text('hospital')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
