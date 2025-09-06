<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('player_achievements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('achievement_id');
            $table->timestamp('earned_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('achievement_id')->references('id')->on('achievements');
        });
    }

    public function down(): void {
        Schema::dropIfExists('player_achievements');
    }
};
