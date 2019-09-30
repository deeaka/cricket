<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtPlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('mt_player_tbl');
        Schema::create('mt_player_tbl', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_id');
            $table->integer('jsy_number')->index();            
            $table->string('first_name', 45)->nullable();
            $table->string('last_name', 45)->nullable();
            $table->text('image_uri')->nullable();            
            $table->string('country', 45)->nullable();
            $table->integer('matches')->default(0);
            $table->integer('run')->default(0);
            $table->integer('highest_scores')->default(0);
            $table->integer('hundreds')->default(0);
            $table->timestamps();
            $table->foreign('team_id')->references('team_id')->on('mt_team_master')->onDelete('cascade');
            $table->unique(['jsy_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mt_player_tbl');
    }
}
