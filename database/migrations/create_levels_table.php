<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('province', 50)->nullable();
            $table->text('story')->nullable();
            $table->text('dialogue')->nullable();
            $table->string('reward', 100)->nullable();
            $table->string('unlocked_next', 50)->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('levels');
    }
};
