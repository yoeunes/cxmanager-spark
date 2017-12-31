<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Collection;

class Functionaltest extends Model
{
    protected $fillable = ['team_id','asset_id','functionaltest_title','functionaltest_type','functionaltest_tag','functionaltest_contractor', 'functionaltest_status','functionaltest_category_order','functionaltest_notes'];    

    public function asset()
    {
    return $this->belongsTo(Asset::class);
    }

    public function team()
    {
    return $this->belongsTo(Team::class);
    }
    
    public function functionaltestquestions()
    {
    	return $this->hasMany(Functionaltestquestion::class);
    }
}
