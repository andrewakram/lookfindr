<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'team_id',
        'role',
    ];

    protected $appends = [
        'user_name',
    ];

    public function projects(){
        return $this->hasMany(Project::class,'team_id','team_id');
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function member(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getUserNameAttribute(){
        return $this->member()->first()->name;
    }
}
