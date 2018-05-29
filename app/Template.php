<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

use DB;

class Template extends Model
{
    protected $fillable = ['user_id','project_id','template_name','template_type','assettype_id','status'];

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function project()
    {
    return $this->belongsTo(Project::class);
    }

    public function assettype()
    {
    return $this->belongsTo(Assettype::class);
    }
    
    public function checklisttemplate()
    {
    	return $this->hasMany(Checklisttemplate::class);
    }
    
    public function fpttemplate()
    {
    	return $this->hasMany(FunctionalTesttemplate::class);
    }

    public function addChecklistTemplates( $templateid, $assettypeid )
    {
         //add checklists to the template from the available global templates and get the new checklist id

        $checklisttemplates = Checklisttemplate::where('assettype_id', $assettypeid)->where('checklist_status', 'template')->get();

        foreach ($checklisttemplates as $checklisttemplate) {
            $cltemp = new Checklisttemplate;
            $cltemp->team_id = Auth::user()->currentTeam->id;
            $cltemp->template_id = $templateid;
            $cltemp->assettype_id = $checklisttemplate->assettype_id;
            $cltemp->checklist_title = $checklisttemplate->checklist_title;
            $cltemp->checklist_tag = "";
            $cltemp->checklist_contractor = $checklisttemplate->checklist_contractor;
            $cltemp->checklist_status = "0";
            $cltemp->checklist_type = $checklisttemplate->checklist_type;
            $cltemp->checklist_category_order = $checklisttemplate->checklist_category_order;
            $cltemp->checklist_notes = $checklisttemplate->checklist_notes;           
            $cltemp->save();

            $checklisttemplateid = DB::getPdo()->lastInsertId(); //get the id of the last checklisttemplate

            // add questions to each checklist based on the templates
            $questiontemplates = Checklistquestiontemplate::where('checklisttemplate_id', $checklisttemplate->id)->get();

                foreach ($questiontemplates as $question) {
                     $qstntempl = new Checklistquestiontemplate;
                     $qstntempl->team_id = Auth::user()->currentTeam->id;
                     $qstntempl->checklisttemplate_id = $checklisttemplateid;
                     $qstntempl->question_text = $question->question_text;
                     $qstntempl->question_order = $question->question_order;                
                     $qstntempl ->save();
             } 
        }
        return $templateid;
    }

    public function addFunctionaltestTemplates( $templateid, $assettype_id )
    {
        $fpttemplates = Functionaltesttemplate::where('assettype_id', $assettype_id)->where('functionaltest_status', 'Not Started')->get();

        foreach ($fpttemplates as $ftptemplate) {
            $fpttempl = new Functionaltesttemplate;
            $fpttempl->team_id = Auth::user()->currentTeam->id;
            $fpttempl->template_id = $templateid;
            $fpttempl->assettype_id = $ftptemplate->assettype_id;
            $fpttempl->functionaltest_title = $ftptemplate->functionaltest_title;
            $fpttempl->functionaltest_tag = $ftptemplate->functionaltest_tag;
            $fpttempl->functionaltest_contractor = $ftptemplate->functionaltest_contractor;
            $fpttempl->functionaltest_status = "0";
            $fpttempl->functionaltest_type = "Project Template"; 
            // this is an instantiated type of test. Hence the type is asset
            // There can also be project level test, as in a  project template. type would be = project template
            // there can also be global level tests as in global templates. type would be = global template
            // This is still being rethought
            $fpttempl->functionaltest_category_order = $ftptemplate->functionaltest_category_order;
            $fpttempl->functionaltest_notes = $ftptemplate->functionaltest_notes;
            $fpttempl->save();

            // add questions to the FPTs. Get the questions from the question templates based on the template type
            $fpttemplateid = DB::getPdo()->lastInsertId();
            $fptquestiontemplates = Functionaltestquestiontemplate::where('functionaltesttemplate_id', $ftptemplate->id )->get();

            foreach ($fptquestiontemplates as $fptquestiontemplate) {
                $fptq = new Functionaltestquestiontemplate;
                $fptq->team_id = Auth::user()->currentTeam->id;
                $fptq->functionaltesttemplate_id = $fpttemplateid;
                $fptq->control_sequence = $fptquestiontemplate->control_sequence;
                $fptq->question_text = $fptquestiontemplate->question_text;
                $fptq->question_order = $fptquestiontemplate->question_order;
                $fptq->question_status = "0";
                $fptq->save();
            }
        }
        return $templateid;
    }
}
