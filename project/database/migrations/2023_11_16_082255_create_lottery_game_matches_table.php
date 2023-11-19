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
        Schema::create('lottery_game_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('winner_id')->nullable()->default(NULL);
            $table->string('start_date');
            $table->string('start_time');
            $table->boolean('is_finished')->default(false);
            $table->foreign('game_id')->references('id')->on('lottery_games')->onDelete('CASCADE');
            $table->foreign('winner_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lottery_game_matches');
    }
};
