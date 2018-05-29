<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Checklist extends Model
{
    protected $fillable = ['team_id','asset_id','checklist_title','checklist_type','checklist_tag','checklist_contractor', 'checklist_status','checklist_category_order','checklist_notes'];    

    public function asset()
    {
    return $this->belongsTo(Asset::class);
    }

    public function team()
    {
    return $this->belongsTo(Team::class);
    }
    
    public function questions()
    {
    	return $this->hasMany(Checklistquestion::class);
    }

}
