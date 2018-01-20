<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Validator;

use Storage;

use Auth;

use App\Project;

use App\Team;

use App\User;

use App\Asset;

use App\Issue;

use App\Checklist;

use App\Question;

use DB;

class ReportController extends Controller
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

    public function checklistreport(Checklist $checklist)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        return view('report.checklist', compact('checklist', 'project'));
    }

    public function checklistsuitereport(Asset $asset)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();

        return view('report.checklistsuite', compact('asset', 'project'));
    }

    public function checklistoverallreport()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $assettypes = Asset::where('team_id', Auth::user()->currentTeam->id)->select('id','asset_title')->distinct()->get();
        // $assettypes->load('checklists');

        // return $assettypes;

        // return view('report.checklistoverall', compact('asset', 'project'));
    }

    public function issuereport(Issue $issue)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();

        return view('report.issue', compact('checklist', 'issue'));
    }

    public function allissuesreport()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $allissues = Issue::where('team_id', Auth::user()->currentTeam->id)->get();
        $pagetitle = "All Issues";

        return view('report.allissues', compact('project', 'allissues', 'pagetitle'));
    }

    public function unresolvedissuesreport()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $allissues = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_status','<>','Resolved')->get();
        $pagetitle = "Unresolved Issues";

        return view('report.allissues', compact('project', 'allissues', 'pagetitle'));
    }

    public function resolvedissuesreport()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $allissues = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_status','Resolved')->get();
        $pagetitle = "Resolved Issues";

        return view('report.allissues', compact('project', 'allissues', 'pagetitle'));
    }

    public function detailedissuesreport()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $allissues = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_status','<>','Resolved')->get();
        $pagetitle = "Unresolved Issues - Detailed";

        return view('report.detailedissues', compact('project', 'allissues', 'pagetitle'));
    }

}
