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
        $contractorsall = Checklist::where('team_id', Auth::user()->currentTeam->id)->pluck('checklist_contractor');
        $contractorsunique = $contractorsall->unique();
        
        // Checklist chart values
            $totclmech = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor', "mechanical")->count();
            $remclmech = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor',  "mechanical")->where('checklist_status','<',100)->count();
            $complclmech = $totclmech - $remclmech;

            $totclelec = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor', "electrical")->count();
            $remclelec = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor',  "electrical")->where('checklist_status','<',100)->count();
            $complclelec = $totclelec - $remclelec;

            $totclplumb = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor', "plumbing")->count();
            $remclplumb = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor',  "plumbing")->where('checklist_status','<',100)->count();
            $complclplumb = $totclplumb- $remclplumb;

            $totclcontr = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor', "controls")->count();
            $remclcontr = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor',  "controls")->where('checklist_status','<',100)->count();
            $complclcontr = $totclcontr - $remclcontr;

            $totcltab = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor', "tab")->count();
            $remcltab = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor',  "tab")->where('checklist_status','<',100)->count();
            $complcltab = $totcltab - $remcltab;
        
            // Issues chart values
                $issuesunres = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_status', "open")->count();
                $issuesres = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_status', "resolved")->count();
                $issuesclosed = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_status', "closed")->count();
                $issuescanceled = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_status', "cancelled")->count();
                $issuespending= Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_status', "cancelled")->count();
             

        $issrem = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_status', '!=', "Resolved")->count();
        // $CLDisciplines[] = ['mechanical', 'electrical', 'plumbing', 'controls', 'tab']; 
        // return $cldisc;
    
        return view('home', compact('project', 'pagetitle', 'assets', 'projissues', 'issuescount', 'assetscount', 'checklistscount', 'projtemplates', 'clchartdisc','clchartrem','complclmech','totclmech','remclmech','complclelec','totclelec','remclelec','complclplumb','totclplumb','remclplumb','complclcontr','totclcontr','remclcontr','complcltab','totcltab','remcltab','issuesunres', 'issuesres', 'issuesclosed','issuescanceled','issuespending'));
    }
}
