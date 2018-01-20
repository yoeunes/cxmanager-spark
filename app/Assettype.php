<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assettype extends Model
{    
    public function checklisttemplates()
    {
    	return $this->hasMany(Checklisttemplate::class);
    }  

    public function functionaltesttemplates()
    {
    	return $this->hasMany(Functionaltesttemplate::class);
    }
}
