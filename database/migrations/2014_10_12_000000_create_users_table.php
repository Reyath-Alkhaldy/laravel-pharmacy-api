<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // cid int  NOT NULL,
    // cname varchar(100)  NOT NULL,
    // contactPhon varchar(100)  NOT NULL,
    // email varchar(100)  NOT NULL,
    // address text  NOT NULL,
    // password varchar(30)  NOT NULL,
    // confirmcode varchar(100)  NOT NULL,
    // joindate date  NOT NULL,
    // CONSTRAINT customer_pk PRIMARY KEY (cid)
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone_number')->unique();
            $table->string('image')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
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
        Schema::dropIfExists('users');
    }
};
