<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    public function members(){
        return $this->hasMany(TeamMember::class,'team_id');
    }

    public function projects(){
        return $this->hasMany(Project::class);
    }
}
