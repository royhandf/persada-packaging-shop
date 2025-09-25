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
            $table->uuid('id')->primary();
            $table->string('order_number')->unique();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

            $table->json('shipping_address');
            $table->string('shipping_courier')->nullable();
            $table->string('shipping_service')->nullable();
            $table->string('shipping_tracking_number')->nullable();

            $table->decimal('subtotal', 15, 2);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2);

            $table->string('payment_method')->nullable();
            $table->string('payment_gateway_id')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->enum('status', [
                'pending_payment',
                'paid',
                'processing',
                'shipped',
                'delivered',
                'completed',
                'cancelled',
                'refunded'
            ])->default('pending_payment');

            $table->text('note')->nullable();
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
