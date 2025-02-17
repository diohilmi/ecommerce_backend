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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            //user_id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            //country
            $table->string('country')->nullable();
            //province
            $table->string('province')->nullable();
            //city
            $table->string('city')->nullable();
            //district
            $table->string('district')->nullable();
            //address
            $table->string('address')->nullable();
            //postal_code
            $table->string('postal_code')->nullable();
            //is_default
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
