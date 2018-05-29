<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Auth;

use App\Project;

use App\Issue;

use App\Asset;

use App\Checklist;

use App\Template;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
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
        $assets = Asset::where('team_id', Auth::user()->currentTeam->id)->get();
        $projissues = Issue::where('team_id', Auth::user()->currentTeam->id)->get();
        $projtemplates = Template::where('project_id', $project->id)->get();
        $pagetitle = "All Assets";
    
        return view('home', compact('project', 'pagetitle', 'assets', 'projissues', 'issuescount', 'assetscount', 'checklistscount','projtemplates'));
    }
}
