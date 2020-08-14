<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'project_id','position'];

    public function ProjectName()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}
