<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->unsignedBigInteger('tourist_id')->nullable();
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->date('check_in')->nullable();

            $table->foreign('tourist_id')->references('tourist_id')->on('tourists');
            $table->foreign('hotel_id')->references('hotel_id')->on('hotels');
        });
    }

    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};
