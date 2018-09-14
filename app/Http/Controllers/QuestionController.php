<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Validator;

use Storage;

use DB;

use Auth;

use App\Project;

use App\Checklist;

use App\Checklistquestion;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        //$this->middleware('subscribed');
    }

    public function create()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();

        return view('question.create', compact('project'));
    }

    public function store(Request $request)
    {
        dd(request()->all());

        $this->validate(request(), [
            'question_order' => 'max:255',
            'question_text' => 'required | max:255',
        ]);

        // Save the question from form values and get the new question id
        $question = new Checklistquestion;
        $question->team_id = Auth::user()->currentTeam->id;
        $question->question_text = $request->Input('question_text');
        $question->checklist_id = $request->Input('checklist_id');
        $question->question_order = $request->Input('question_order');
        $question->question_status = "Not Started";

        $question->save();

        return back();
    }

    public function edit(Checklistquestion $question)
    {
    	$project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $pagetitle = "Edit Question";

    	return view('question.edit', compact('question','project','pagetitle'));
    }

    // public function store(Checklist $checklist, Request $request)
    // {
    //     $question = new Checklistquestion;
    // }

    public function update(Checklistquestion $question, Request $request)
    {   	
        $question->update($request->all());

        return back();
    }

    public function destroy (Checklistquestion $question)
    {          
        $question->delete();
        
        return back();
    }
}
