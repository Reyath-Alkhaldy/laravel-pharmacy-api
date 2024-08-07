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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->constrained('pharmacies')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('number')->unique();
            $table->string('payment_method')->nullable();
            $table->enum('status',['pending','processing','delivering','completed','cancelled','refunded'])->default('pending');
            $table->enum('payment_status',['pending','paid','fail'])->default('pending');
            // $table->float('shipping')->default(0); // عمود الضحن 
            $table->decimal('tax')->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
