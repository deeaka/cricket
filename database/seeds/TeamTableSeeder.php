<?php

use Illuminate\Database\Seeder; 
use Carbon\Carbon;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mt_team_master')->insert([
           ['name' => 'India','logo_uri'=>'http://placehold.it/1500x550','state'=>'','created_at' => Carbon::createFromDate(2014,07,22)->toDateTimeString()],
           ['name' => 'Australia','logo_uri'=>'http://placehold.it/1500x550','state'=>'','created_at' => Carbon::createFromDate(2014,07,22)->toDateTimeString()],
           ['name' => 'South Africa','logo_uri'=>'http://placehold.it/1500x550','state'=>'','created_at' => Carbon::createFromDate(2014,07,22)->toDateTimeString()]
        ]);
    }
}
