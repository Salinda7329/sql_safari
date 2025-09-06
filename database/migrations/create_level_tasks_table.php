<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('level_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->text('introduction')->nullable();
            $table->string('reference_table', 255)->nullable();
            $table->text('task')->nullable();
            $table->text('task_accepting')->nullable();
            $table->text('expected_query')->nullable();
            $table->text('clue')->nullable();
            $table->text('help')->nullable();

            $table->foreign('level_id')->references('id')->on('levels');
        });
    }

    public function down(): void {
        Schema::dropIfExists('level_tasks');
    }
};
