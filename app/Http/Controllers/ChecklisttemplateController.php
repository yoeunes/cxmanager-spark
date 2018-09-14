<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Validator;

use Storage;

use DB;

use Auth;

use App\Project;

use App\Asset;

use App\Template;

use App\Checklisttemplate;

use App\Checklistquestiontemplate;

class ChecklisttemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        //$this->middleware('subscribed');
    }

    public function index()
    {
    	# code...
    }

    public function show(Checklisttemplate $checklisttemplate)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $checklisttemplate->load('template')->load('checklistquestiontemplate');
        $pagetitle = "Checklist Template";

        // return $checklisttemplate;

        return view('template.checklisttemplate', compact('project', 'pagetitle','checklisttemplate'));
    }

    public function createblank(Request $request )
    {
    	// dd($request->all());
    	$project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $pagetitle = "Create Checklist Template";

        $this->validate(request(), [
            'checklist_title' => 'required | max:255',
            'checklist_contractor' => 'required | max:255',
            'checklist_type' => 'max:255',
            'checklist_category_order' => 'required | max:255',
            'checklist_notes' => 'max:1024',
        ]);

        $cltemp = new Checklisttemplate;
        $cltemp->team_id = Auth::user()->currentTeam->id;
        $cltemp->template_id = $request->Input('template_id');
        $cltemp->assettype_id = 0;
        $cltemp->checklist_title = $request->Input('checklist_title');
        $cltemp->checklist_contractor = $request->Input('checklist_contractor');
        $cltemp->checklist_status = "template";
        $cltemp->checklist_type = "Pre-functional";
        $cltemp->checklist_category_order = $request->Input('checklist_category_order');
        $cltemp->checklist_notes = $request->Input('checklist_notes');
        $cltemp->save();

        return back();
    }

    public function editquestion(Checklistquestiontemplate $question)
    {
        return view('template.editchecklistquestion', compact('question'));
    }

    public function update(Checklisttemplate $checklisttemplate, Request $request)
    {
        // dd(request()->all());
        $checklisttemplate->update($request->all());

        return back();
    }

    public function updatequestion(Checklistquestiontemplate $question, Request $request)
    {
        // dd(request()->all());
        $question->question_text = $request->Input('question_text');
        $question->question_order = $request->Input('question_order');

        $question->update();

        return back();
    }

    public function questionstore(Request $request)
    {
        // dd(request()->all());

        $this->validate(request(), [
            'question_order' => 'max:255',
            'question_text' => 'required | max:255',
        ]);

        // Save the question from form values and get the new question id
        $question = new Checklistquestiontemplate;
        $question->team_id = Auth::user()->currentTeam->id;
        $question->question_text = $request->Input('question_text');
        $question->checklisttemplate_id = $request->Input('checklisttemplate_id');
        $question->question_order = $request->Input('question_order');

        $question->save();

        return back();
    }

    public function destroy(Checklisttemplate $checklist)
    {
        Checklistquestiontemplate::where('checklisttemplate_id', $checklist->id)->delete();
        $checklist->delete();

        return back();
    }

    public function destroyquestion(Checklistquestiontemplate $question)
    {
        $question->delete();

        return back();
    }
    
}
