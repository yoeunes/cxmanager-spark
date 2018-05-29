<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Functionaltesttemplate extends Model
{
    public function template()
    {
    return $this->belongsTo(Template::class);
    }

    public function assettype()
    {
    return $this->belongsTo(Assettype::class);
    }

    public function functionaltestquestiontemplates()
    {
    	return $this->hasMany(Functionaltestquestiontemplate::class);
    }
}
