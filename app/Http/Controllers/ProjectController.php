<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Validator;

use Storage;

use DB;

use Auth;

use App\Project;

use App\Issue;

use App\Asset;

use App\Checklist;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::All();
        
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();

        return view('project.index', compact('projects', 'issuescount', 'assetscount', 'checklistscount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // dd(request()->all());
        $this->validate(request(), [
            'project_title' => 'required',
            'project_name' => 'required',
            'project_type' => 'required',
            'project_status' => 'required',
            'project_start_date' => 'required|date',
            'project_end_date' => 'required|date',
        ]);
            if ($request->file('image'))
            {
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                Storage::put('public/upload/images/'.$filename, file_get_contents($request->file('image')->getRealPath()));
            }
            else 
            {
                $filename = "avatar-bldg-1.jpg";
            }
            
            $project = new Project;
            $project->team_id = Auth::user()->currentTeam->id;
            $project->project_number = $request->Input('project_number');
            $project->project_title = $request->Input('project_title');
            $project->project_name = $request->Input('project_name');
            $project->project_type = $request->Input('project_type');
            $project->project_status = $request->Input('project_status');
            $project->project_percent_complete = $request->Input('project_percent_complete');
            $project->project_start_date= $request->Input('project_start_date');
            $project->project_end_date = $request->Input('project_end_date');
            $project->project_construction_cost = $request->Input('project_construction_cost');
            $project->project_cx_cost = $request->Input('project_cx_cost');
            $project->project_notes = $request->Input('project_notes');
            $project->thumbnail = $filename;

            // return $project;

            $project->save();
        

            $projects = Project::All(); //grab all projects to display on home page

            //print_r($project);
            return view('project.index', compact('projects'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        session(['projid' => '$project->id']);

        $project->load('issues');
        //$project->load('assets');
        $project->load('user');

        $issuescount = $project->issues->count();
        $assetscount = $project->assets->count();
        $checklistscount = $project->checklists->count();
        $designissuescount = $project->issues->where('issue_type', 'Design')->count();
        $constructionissuescount = $project->issues->where('issue_type', 'Construction')->count();
        $submittalissuescount = $project->issues->where('issue_type', 'Submittal')->count();
        $testingissuescount = $project->issues->where('issue_type', 'Testing')->count();
        $checklistissuescount = $project->issues->where('issue_type', 'Checklist')->count();
        $resolvedissuescount = $project->issues->where('issue_status', 'Resolved')->count();
        $unresolvedissuescount = $issuescount - $resolvedissuescount;
        $highpriorityissuescount = $project->issues->where('issue_priority', 'High')->count();
        $mediumpriorityissuescount = $project->issues->where('issue_priority', 'Medium')->count();
        $lowpriorityissuescount = $project->issues->where('issue_priority', 'Low')->count();


        return view('project.show', compact('project','issuescount', 'designissuescount', 'constructionissuescount', 'submittalissuescount', 'testingissuescount', 'checklistissuescount', 'resolvedissuescount', 'unresolvedissuescount', 'highpriorityissuescount', 'mediumpriorityissuescount', 'lowpriorityissuescount', 'assetscount', 'checklistscount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {  
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();

        return view('project.edit', compact('project', 'issuescount', 'assetscount', 'checklistscount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //store new image on disk
        if ($request->file('image'))
        {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            Storage::put('public/upload/images/'.$filename, file_get_contents($request->file('image')->getRealPath()));
            $oldfilename = $project->thumbnail;

            if ($oldfilename == "avatar-bldg-1.jpg")
            {
                $project->update($request->all());
                $project->update(['thumbnail' => $filename]); 
            }

            else
            {
                Storage::delete('public/upload/images/'.$oldfilename);
                $project->update($request->all());
             
            }
               $project->update(['thumbnail' => $filename]);
        }

        else
        {

           $project->update($request->all());
        }       

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect('/home');
    }
    
        /**
         * Upload an image to the project to be used instead of the defualt avatar.
         *
         * @return \Illuminate\Http\Response
         */
        public function addimage(Project $project)
        { 
            $issuescount = $project->issues->count();
            $assetscount = $project->assets->count();
            $checklistscount = $project->checklists->count();

            return view('project.addimage', compact('project', 'issuescount', 'assetscount', 'checklistscount'));
        }
}
