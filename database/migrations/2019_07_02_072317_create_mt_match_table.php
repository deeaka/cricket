<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mt_match_tbl', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('first_team_id')->index();
            $table->unsignedBigInteger('second_team_id')->index();
            $table->unsignedBigInteger('winner_team_id')->index();
            $table->timestamps();
            $table->foreign('first_team_id')->references('team_id')->on('mt_team_master')->onDelete('cascade');
            $table->foreign('second_team_id')->references('team_id')->on('mt_team_master')->onDelete('cascade');
            $table->foreign('winner_team_id')->references('team_id')->on('mt_team_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mt_match_tbl');
    }
}
