<?php

namespace App;

use Laravel\Spark\Team as SparkTeam;
use ZiNETHQ\SparkRoles\Traits\CanHaveRoles;

class Team extends SparkTeam
{
    // use CanHaveRoles;
    
    protected $fillable = ['user_id','project_number','project_title','project_name','project_type','project_status','project_percent_complete','project_start_date','project_end_date','project_construction_cost','project_cx_cost','project_notes','thumbnail'];
    
    // protected $guarded = [];

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->haOne(Asset::class);
    }

    public function assets()
    {
    	return $this->hasMany(Asset::class);
    }
    
    public function documents()
    {
    	return $this->hasMany(Document::class);
    }

    public function checklists()
    {
    	return $this->hasMany(Checklist::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
    
    public function messages()
    {
    	return $this->hasMany(Message::class);
    }
    
    public function schedules()
    {
    	return $this->hasMany(Schedule::class);
    }

    public function spaces()
    {
    	return $this->hasMany(Space::class);
    }

    public function tasks()
    {
    	return $this->hasMany(Task::class);
    }

    public function addIssue($issue)
    {
        $this->issues()->create($issue);
    }
}
