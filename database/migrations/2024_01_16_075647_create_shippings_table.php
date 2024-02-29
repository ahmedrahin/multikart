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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->integer('base_id')->nullable();
            $table->integer('base_charge')->nullable();
            $table->string('provider_name')->nullable();
            $table->unsignedInteger('provider_charge')->nullable();
            $table->integer('status')->default(1)->comment('1-active, 2=inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
