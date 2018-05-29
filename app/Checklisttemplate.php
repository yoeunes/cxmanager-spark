<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Auth;
use DB;

class Checklisttemplate extends Model
{

    public function template()
    {
    return $this->belongsTo(Template::class);
    }

    public function assettype()
    {
    return $this->belongsTo(Assettype::class);
    }

    public function checklistquestiontemplate()
    {
    	return $this->hasMany(Checklistquestiontemplate::class);
    }

    public function addBlankChecklistTemplates( $templateid, $assettype, $checklisttitle, $checklistcontractor, $checklisttype, $checklistcategoryorder, $checklistnotes )
    {
         //add blank checklist template to the asset template

            $cltemp = new Checklisttemplate;
            $cltemp->team_id = Auth::user()->currentTeam->id;
            $cltemp->template_id = $templateid;
            $cltemp->assettype_id = $assettype;
            $cltemp->checklist_title = $checklisttitle;
            $cltemp->checklist_tag = "";
            $cltemp->checklist_contractor = $checklistcontractor;
            $cltemp->checklist_status = "0";
            $cltemp->checklist_type = $checklisttype;
            $cltemp->checklist_category_order = $checklistcategoryorder;
            $cltemp->checklist_notes = $checklistnotes;           
            $cltemp->save();  
        
        return $templateid;
    }

}
