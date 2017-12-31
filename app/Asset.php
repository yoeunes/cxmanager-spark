<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Asset extends Model
{
    protected $fillable = ['team_id','space_id','asset_number','asset_title','asset_type','asset_tag','asset_status','asset_notes','thumbnail'];

    public function space()
    {
    return $this->belongsTo(Space::class);
    }

    public function team()
    {
    	return $this->belongsTo(Team::class);
    }
    
    public function checklists()
    {
    	return $this->hasMany(Checklist::class);
    }

    public function functionaltests()
    {
        return $this->hasMany(Functionaltest::class);
    }
    
    public function checklisttemplates()
    {
        return $this->hasMany(Checklisttemplate::class);
    }

    public function addChecklist($checklist)
    {
        return $this->checklists()->create($checklist);
    }
}
