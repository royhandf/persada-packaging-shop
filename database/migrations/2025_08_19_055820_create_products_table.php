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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignUuid('category_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('product_variants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained()->onDelete('cascade');
            $table->string('sku')->unique()->nullable();
            $table->string('name');
            $table->decimal('price', 15, 2);
            $table->integer('stock')->default(0);
            $table->integer('moq')->default(1);

            $table->unsignedInteger('weight_in_grams')->default(0);
            $table->unsignedInteger('length_in_cm')->nullable(); 
            $table->unsignedInteger('width_in_cm')->nullable();  
            $table->unsignedInteger('height_in_cm')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_variants');
    }
};