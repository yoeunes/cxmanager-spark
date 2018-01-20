<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Auth;
use DB;

class Asset extends Model
{
    protected $fillable = ['team_id','space_id','asset_number','asset_title','asset_type','asset_tag','asset_status','asset_notes','thumbnail'];

    public function space()
    {
    return $this->belongsTo(Space::class);
    }

    public function team()
    {
    	return $this->belongsTo(Team::class);
    }
    
    public function checklists()
    {
    	return $this->hasMany(Checklist::class);
    }

    public function functionaltests()
    {
        return $this->hasMany(Functionaltest::class);
    }
    
    public function checklisttemplates()
    {
        return $this->hasMany(Checklisttemplate::class);
    }

    public function addChecklists( $assetid, $assettypeid, $assettag )
    {
         //add checklists to the asset from the available templates and get the new checklist id

        $checklisttemplates = Checklisttemplate::where('assettype_id', $assettypeid)->get();

        foreach ($checklisttemplates as $checklist) {
            $cl = new Checklist;
            $cl->team_id = Auth::user()->currentTeam->id;
            $cl->asset_id = $assetid;
            $cl->checklist_title = $checklist->checklist_title;
            $cl->checklist_tag = $assettag . " - " . $checklist->checklist_title;
            $cl->checklist_contractor = $checklist->checklist_contractor;
            $cl->checklist_status = "0";
            $cl->checklist_type = $checklist->checklist_type;
            $cl->checklist_category_order = $checklist->checklist_category_order;
            $cl->checklist_notes = $checklist->checklist_notes;           
            $cl->save();

            $checklistid = DB::getPdo()->lastInsertId(); //get the id of the last checklist

            // add questions to each checklist based on the templates
            $questiontemplates = Questiontemplate::where('checklisttemplate_id', $checklist->id)->get();

                foreach ($questiontemplates as $question) {
                     $qstn = new Question;
                     $qstn->team_id = Auth::user()->currentTeam->id;
                     $qstn->checklist_id = $checklistid;
                     $qstn->question_text = $question->question_text;
                     $qstn->question_order = $question->question_order;
                     $qstn->question_status = "0";                    
                     $qstn ->save();
             } 
        }
        return $assetid;
    }

    public function addFunctionaltests( $assetid, $assettypeid, $assettag )
    {
        $fpttemplates = Functionaltesttemplate::where('assettype_id', $assettypeid)->get();

        foreach ($fpttemplates as $functionaltest) {
            $fpt = new Functionaltest;
            $fpt->team_id = Auth::user()->currentTeam->id;
            $fpt->asset_id = $assetid;
            $fpt->functionaltest_title = $functionaltest->functionaltest_title;
            $fpt->functionaltest_tag = $assettag . " - " . $functionaltest->functionaltest_tag;
            $fpt->functionaltest_contractor = $functionaltest->functionaltest_contractor;
            $fpt->functionaltest_status = "0";
            $fpt->functionaltest_type = "asset"; 
            // this is an instantiated type of test. Hence the type is asset
            // There can also be project level test, as in a  project template. type would be = project template
            // there can also be global level tests as in global templates. type would be = global template
            // This is still being rethought
            $fpt->functionaltest_category_order = $functionaltest->functionaltest_category_order;
            $fpt->functionaltest_notes = "";
            $fpt->save();

            // add questions to the FPTs. Get the questions from the question templates based on the template type
            $fptid = DB::getPdo()->lastInsertId();
            $fptquestions = Functionaltestquestiontemplate::where('functionaltesttemplate_id', $functionaltest->id )->get();

            foreach ($fptquestions as $fptquestion) {
                $fptq = new Functionaltestquestion;
                $fptq->team_id = Auth::user()->currentTeam->id;
                $fptq->functionaltest_id = $fptid;
                $fptq->control_sequence = $fptquestion->control_sequence;
                $fptq->question_text = $fptquestion->question_text;
                $fptq->question_order = $fptquestion->question_order;
                $fptq->question_status = "0";
                $fptq->save();
            }
        }
        return $assetid;
    }
}
