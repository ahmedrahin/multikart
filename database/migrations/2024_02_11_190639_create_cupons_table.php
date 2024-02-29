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
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('cupon_code');
            $table->enum('type', ['percent', 'fixed'])->default('fixed');
            $table->double('discount_amount', 10, 2)->nullable();
            $table->double('min_amount', 10, 2)->nullable();
            $table->integer('max_uses')->nullable();
            $table->integer('max_uses_user')->nullable();
            $table->unsignedInteger('status')->default(1)->comment("1=Active, 0=Inactive");
            $table->dateTime('start_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupons');
    }
};
