<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Functionaltestquestion extends Model
{  
    protected $fillable = ['team_id','functionaltest_id','control_sequence','question_text','question_order','question_status','answer_design','answer_installed','answer_accepted','answer_comment'];

    public function functionaltest()
    {
    return $this->belongsTo(Functionaltest::class);
    }

    public function team()
    {
    return $this->belongsTo(Team::class);
    }
}
