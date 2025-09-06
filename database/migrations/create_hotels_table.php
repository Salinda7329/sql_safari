<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id('hotel_id');
            $table->string('name', 100)->nullable();
            $table->string('city', 50)->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('amenities', 200)->nullable();

            $table->foreign('province_id')->references('province_id')->on('provinces');
        });
    }

    public function down(): void {
        Schema::dropIfExists('hotels');
    }
};
