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
        // Schema::dropIfExists('orders');
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            //user_id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // //address_id
            // $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            //seller_id
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            //total_price
            $table->string('total_price', 15, 2);
            //shipping_price
            $table->string('shipping_price', 15, 2);
            //grand_total
            $table->decimal('grand_total', 15, 2);
            //status string
            $table->string('status')->default('pending');
            //payment va name
            $table->string('payment_va_name')->nullable();
            //payment va number
            $table->string('payment_va_number')->nullable();
            //shipping service
            $table->string('shipping_service')->nullable();
            //shipping receipt
            $table->string('shipping_number')->nullable();
            //transaction number
            $table->string('transaction_number')->nullable();
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
