<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('mt_team_master');
        Schema::create('mt_team_master', function (Blueprint $table) {
            $table->bigIncrements('team_id');
            $table->string('name', 45)->nullable();
            $table->text('logo_uri')->nullable();
            $table->string('state', 191)->nullable();
            $table->timestamps();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mt_team_master');
    }
}
