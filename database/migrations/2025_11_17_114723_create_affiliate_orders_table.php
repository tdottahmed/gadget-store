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
        Schema::create('affiliate_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('referred_by')->nullable()->index();

            $table->boolean('first_order')->default(0);
            $table->boolean('bonus_applied')->default(0);
            $table->decimal('bonus_amount', 10, 2)->nullable();

            $table->boolean('notified')->default(0); // delivered_notify equivalent

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_orders');
    }
};
