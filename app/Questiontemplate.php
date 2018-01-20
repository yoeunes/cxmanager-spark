<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questiontemplate extends Model
{
    public function checklistemplate()
    {
    return $this->belongsTo(Checklisttemplate::class);
    }
}
