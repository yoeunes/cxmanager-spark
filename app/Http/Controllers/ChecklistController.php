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

use App\Checklist;

use App\Checklistquestion;

class ChecklistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        //$this->middleware('subscribed');
    }

    public function index()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        if ($project == "")
        {
            return view('project.create');
        }
        
        $checklists = DB::table('checklists')->where('team_id', Auth::user()->currentTeam->id)->get();
        // $checklists->load('asset');
        $pagetitle = "All Checklists";
    
        

        return view('checklist.index', compact('project', 'pagetitle', 'checklists'));
    }

    public function show(Checklist $checklist)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $checklist->load('asset')->load('questions');
        $commentscount = Checklistquestion::where('checklist_id', $checklist->id )->where('answer_comment', '<>', '')->count();
        // return $checklist;
        $pagetitle = "Customize Checklist";

        return view('checklist.show', compact('checklist', 'pagetitle', 'project', 'commentscount'));
    }

    public function edit( Checklist $checklist )
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $checklist->load('asset')->load('questions');
        $contractors = DB::table('contractors')->get();
        $commentscount = Checklistquestion::where('checklist_id', $checklist->id )->where('answer_comment', '<>', '')->count();
        $pagetitle = "Fill Checklist";

        // return $checklist->checklist_contractor;

        return view('checklist.edit', compact('project', 'pagetitle','checklist','contractors', 'commentscount'));
    }

    public function store(Request $request)
    {
        // dd(request()->all());
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $checklist = Checklist::where('id', $request->Input('checklistid'))->get();
        $questions = Checklistquestion::where('checklist_id', $request->Input('checklistid'))->get();
        // return $checklist;

        // Save Checklist Data
        $checklist->checklist_title = $request->Input('checklist_title'); 
        $checklist->checklist_contractor = $request->Input('checklist_contractor');
        $checklist->checklist_tag = $request->Input('checklist_tag'); 
        $checklist->checklist_notes = $request->Input('checklist_notes'); 
        $checklist->save();
  
        return back();         
    }

    public function add(Asset $asset, Request $request)
    {
        //dd(request()->all());

        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();

        $this->validate(request(), [
            'checklist_title' => 'required | max:255',
            'checklist_tag' => 'required | max:255',
            'checklist_contractor' => 'required|max:255',
            'checklist_status' => 'required | max:255',
            'checklist_type' => 'required | max:255',
            'checklist_category_order' => 'required | max:255',
            'checklist_notes' => 'max:1024',
        ]);
        // Save the asset from form values and get the new asset id
        // dd(request()->all());
        $checklist = new Checklist;
        $checklist->team_id = Auth::user()->currentTeam->id;
        $checklist->asset_id = $request->Input('asset_id');
        $checklist->checklist_title = $request->Input('checklist_title');
        $checklist->checklist_tag = $request->Input('checklist_tag');
        $checklist->checklist_contractor = $request->Input('checklist_contractor');
        $checklist->checklist_status = $request->Input('checklist_status');
        $checklist->checklist_type = $request->Input('checklist_type');
        $checklist->checklist_category_order = $request->Input('checklist_category_order');
        $checklist->checklist_notes = $request->Input('checklist_notes');
        $checklist->save();

        return back();
    }

    public function update(Checklist $checklist, Request $request)
    {   
        // dd(request()->all());
        $checklist->update($request->all());

        $questions = Checklistquestion::where('checklist_id', $checklist->id)->get();

        // Save Questions Data
        foreach ($questions as $question)
        {
                if ( $request->Input($question->id.'-answer_design')) {
                    if( Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa' || Auth::user()->ownsTeam(Auth::user()->currentTeam)){
                       $question->answer_design = $request->Input($question->id.'-answer_design'); 
                    }
                    
                }
                if ( $request->Input($question->id.'-answer_submitted')) {
                    if( Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa' || Auth::user()->ownsTeam(Auth::user()->currentTeam)){
                        $question->answer_submitted = $request->Input($question->id.'-answer_submitted');
                    }
                }
                if ( $request->Input($question->id.'-answer_installed')) {
                    $question->answer_installed = $request->Input($question->id.'-answer_installed');
                }
                if ( $request->Input($question->id.'-answer_accepted')) {
                    $question->answer_accepted = $request->Input($question->id.'-answer_accepted');
                }
                if ( $request->Input($question->id.'-answer_cxreview')) {
                    $question->answer_cxreview = $request->Input($question->id.'-answer_cxreview');
                }
                if  ($request->Input($question->id.'-answer_comment')) {
                    $question->answer_comment = $request->Input($question->id.'-answer_comment');
                }
                $question->update();                
        }

        // Update Question Status
        $questions =  Checklistquestion::where('checklist_id', $checklist->id)->get();

        foreach ($questions as $question)
        {
                $questionstatuscount = 0;
                if ( $question->answer_installed || $question->answer_accepted ) {
                    $questionstatuscount = 1;
                }

                $question->question_status = $questionstatuscount;
                $question->update();                
        }

        // Update checklist status       
            $numerator = Checklistquestion::where('checklist_id', $checklist->id)->where( 'question_status', 1 )->count();
            $denominator = Checklistquestion::where('checklist_id', $checklist->id)->count();
            $percentage = ($numerator/$denominator) * 100;
            $checklist->checklist_status = number_format($percentage, 2); 
            $checklist->update();

        //update asset status
        $asset = Asset::where('id', $checklist->asset_id)->first();
        $checklistcount = Checklist::where('asset_id', $checklist->asset_id)->count();
        $checkliststatussum = Checklist::where('asset_id', $checklist->asset_id)->sum('checklist_status');
        $assetstatus = $checkliststatussum / $checklistcount;
        $asset->asset_status = number_format($assetstatus, 2);
        $asset->update();
        // return $asset->asset_status;

        return back();
    }

    public function destroy (Checklist $checklist)
    {
            
        Checklistquestion::where('checklist_id', $checklist->id)->delete();           
        $checklist->delete();
        
        return back();
    }
}
