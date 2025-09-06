<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('player_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id')->nullable();
            $table->integer('highest_level')->default(1);
            $table->unsignedInteger('intro_status')->default(0);
            $table->integer('current_level')->default(1);
            $table->integer('current_task_id')->default(1);
            $table->integer('attempts_left')->default(3);

            $table->foreign('player_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void {
        Schema::dropIfExists('player_progress');
    }
};
