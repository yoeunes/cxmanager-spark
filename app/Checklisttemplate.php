<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Checklisttemplate extends Model
{

    
    public function questiontemplates()
    {
    	return $this->hasMany(Questiontemplate::class);
    }

}
