<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Functionaltesttemplate extends Model
{
    protected $fillable = ['team_id','template_id', 'assettype_id', 'asset_id','functionaltest_title','functionaltest_type','functionaltest_tag','functionaltest_contractor', 'functionaltest_status','functionaltest_category_order','functionaltest_notes']; 

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
