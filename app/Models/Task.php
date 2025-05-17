<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'status',
        'project_id',
        'user_id',
        'due_date',
    ];

    protected $appends = [
        'project_name',
        'user_name',
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function member(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getProjectNameAttribute(){
        return $this->project()->first()->name;
    }

    public function getUserNameAttribute(){
        if(isset($this->attributes['user_id']))
            return $this->member()->first()->name;
        return null;
    }
}
