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

class IssueController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }

    public function index()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        if ($project == "")
        {
            return view('project.create');
        }
        
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
        
        $projissues = DB::table('issues')->where('team_id', Auth::user()->currentTeam->id)->where('issue_status','<>','Resolved')->get();
        
        $pagetitle = 'Unresolved Issues';
        
        return view('issue.index', compact('project', 'pagetitle', 'projissues', 'issuescount', 'assetscount', 'checklistscount'));
    }

    public function resolved()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        if ($project == "")
        {
            return view('project.create');
        }
        
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
        
        $projissues = DB::table('issues')->where('team_id', Auth::user()->currentTeam->id)->where('issue_status','Resolved')->get();

        $pagetitle = 'Resolved Issues';
        
        return view('issue.index', compact('project', 'pagetitle', 'projissues', 'issuescount', 'assetscount', 'checklistscount'));
    }
    
        public function all()
        {
            $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
            if ($project == "")
            {
                return view('project.create');
            }
            
            $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
            $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
            $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
            
            $projissues = DB::table('issues')->where('team_id', Auth::user()->currentTeam->id)->get();
    
            $pagetitle = 'All Issues';
            
            return view('issue.index', compact('project', 'pagetitle', 'projissues', 'issuescount', 'assetscount', 'checklistscount'));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        return view('issue.create', compact('project', 'issuescount', 'assetscount', 'checklistscount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'issue_title' => 'required|max:255',
            'issue_created_date' => 'required',
            'issue_response_date' => 'required',
            'issue_response_person' => 'required',
            'issue_type' => 'required',
            'issue_status' => 'required',
            'issue_priority' => 'required',
            'issue_description' => 'required',
        ]);

        Auth::user()->currentTeam->addIssue([
            'user_id' => auth()->id(),
            'issue_title' => request('issue_title'),
            'issue_created_date' => request('issue_created_date'),
            'issue_response_date' => request('issue_response_date'),
            'issue_response_person'=> request('issue_response_person'),
            'issue_type' => request('issue_type'),
            'issue_status' => request('issue_status'),
            'issue_priority' => request('issue_priority'),
            'issue_description' => request('issue_description'),
            'issue_recommendation' => request('issue_recommendation'),
            'issue_resolution' => request('issue_resolution')
        ]);

        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
       // $projissues = DB::table('issues')->where('team_id', Auth::user()->currentTeam->id)->paginate(10);

        return redirect('/issue');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $issue->load('issuecomments');

        $photos = DB::table('images')->where('issue_id', $issue->id)->get();

        // ->leftjoin('issuesimages', 'images.id', '=', 'issuesimages.issue_id')
        // ->get();

        return view('issue.show', compact('issue','photos','project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        
        // return $issue;
        return view('issue.edit', compact('issue','project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        $issue->update($request->all());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $issue->delete();

        return redirect('/issue');
    }

    public function addphoto(Request $request, Issue $issue)
    {
        // $image = $request->file('image');
        // $filename = $image->getClientOriginalName();
        // Storage::put('public/upload/images/'.$filename, file_get_contents($request->file('image')->getRealPath()));

        $filename = $request->file('image')->store('public/upload/images');

        $img_title = $request->Input('image_title');
        $img_description = $request->Input('image_description');
        $img_filepath = $filename;
        $img_status = "active";

        DB::insert('insert into images (user_id, team_id, issue_id, image_title, image_description, image_filepath, image_status) values (?, ?, ?, ?, ?, ?, ?)', [auth()->id(), Auth::user()->currentTeam->id, $issue->id, $img_title, $img_description, $img_filepath, $img_status]);

        return back();
    }
    
        public function deletephoto(Request $request, $photo)
        {
            

            $filepath = DB::table('images')->where('id', $photo)->value('image_filepath');

            // $path = $image->image_filepath;

            // return $filepath;
            Storage::delete($filepath);

            DB::table('images')->where('id', '=', $photo )->delete();
    
            return back();
        }
}
