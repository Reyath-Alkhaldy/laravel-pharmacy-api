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
        // final String id;
        // final String nameEn;
        // final String nameAr;
        // final String image;
        // final double price;
        // final String description;
        //   bool selected;
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('image');
            $table->unsignedDouble('price');
            $table->unsignedDouble('discount');
            $table->integer('count')->default(0);
            $table->string('description')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->nullOnDelete();
            $table->foreignId('pharmacy_id')->constrained('pharmacies')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    // m_id int  NOT NULL AUTO_INCREMENT,
    // sic_name varchar(100)  NOT NULL,
    // subcat_id int  NOT NULL,
    // descrption text  NOT NULL,
    // mark_name varchar(100)  NOT NULL,
    // price decimal(6,2)  NOT NULL,
    // discount decimal(6,2)  NOT NULL,
    // sub_cat_id int  NOT NULL,
    // ar_name varchar(100)  NOT NULL,
    // en_name varchar(100)  NOT NULL,
    // pharmacy_id int  NOT NULL,
    // CONSTRAINT medicin_pk PRIMARY KEY (m_id)
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
