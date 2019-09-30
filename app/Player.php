<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Player extends Authenticatable
{
    protected $table = 'mt_player_tbl';
    protected $primaryKey = 'id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jsy_number', 'first_name', 'last_name',
    ];

     public function team()
    {
        return $this->belongsTo(Team::class, 'team_id','team_id');
    }
    
     public function setAvatar($avatarFile)
    {
        $this->image_uri = $avatarFile;
        $this->save();
    }

}
