<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{  
    protected $fillable = ['team_id','checklist_id','question_text','question_order','question_status','answer_design','answer_submitted','answer_installed','answer_accepted','answer_cxreview','answer_comment'];

    public function checklist()
    {
    return $this->belongsTo(Checklist::class);
    }

    public function team()
    {
    return $this->belongsTo(Team::class);
    }
}
