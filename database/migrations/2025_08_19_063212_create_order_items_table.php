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
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('product_variant_id')->constrained()->onDelete('set null');

            // Snapshot Data - SANGAT PENTING
            $table->string('product_name');
            $table->string('variant_name');
            $table->string('sku');
            $table->decimal('price_at_purchase', 15, 2);
            $table->integer('quantity');
            $table->unsignedInteger('weight_in_grams');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
