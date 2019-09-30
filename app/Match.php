<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Match extends Authenticatable
{
    protected $table = 'mt_match_tbl';
    protected $primaryKey = 'id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_team_id', 'second_team_id', 'winner_team_id',
    ];

    public function firstTeam()
    {
        return $this->belongsTo(Team::class, 'first_team_id','team_id');
    }
    
    public function secondTeam()
    {
        return $this->belongsTo(Team::class, 'second_team_id','team_id');
    }
    
    public function winnerTeam()
    {
        return $this->belongsTo(Team::class, 'winner_team_id','team_id');
    }

}
