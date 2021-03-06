<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateArcheryPlayerStatsAddRoundNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archery_player_stats', function (Blueprint $table) {
            //
            $table->integer('round_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archery_player_stats', function (Blueprint $table) {
            //
            $table->integer('round_number')->nullable();
        });
    }
}
