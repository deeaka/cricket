<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'mt_team_master';
    protected $primaryKey = 'team_id';
    
    public function players()
    {
        return $this->hasMany(Match::class, 'team_id','team_id');
    }  
    
    public function firstTeamMatch()
    {
        return $this->belongsTo(Match::class, 'team_id','first_team_id');
    }  
    
    public function secondTeamMatch()
    {
        return $this->belongsTo(Match::class, 'team_id','second_team_id');
    }  
    
    public function winnerTeamMatch()
    {
        return $this->belongsTo(Match::class, 'team_id','winner_team_id');
    }  
}
