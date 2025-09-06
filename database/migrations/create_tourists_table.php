<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tourists', function (Blueprint $table) {
            $table->id('tourist_id');
            $table->string('name', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->integer('age')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tourists');
    }
};
