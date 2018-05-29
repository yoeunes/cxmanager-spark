<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklistquestiontemplate extends Model
{
    public function checklistemplate()
    {
    return $this->belongsTo(Checklisttemplate::class);
    }
}
