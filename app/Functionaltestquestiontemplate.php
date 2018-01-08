<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Functionaltestquestiontemplate extends Model
{
    public function functionaltesttemplate()
    {
    return $this->belongsTo(Functionaltesttemplate::class);
    }
}
