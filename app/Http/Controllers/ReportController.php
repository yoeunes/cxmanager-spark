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

    public function issuereport()
    {
        //
    }

    public function allissuesreport()
    {
        //
    }

}
