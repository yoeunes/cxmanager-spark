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

    public function index()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        if ($project == "")
        {
            return view('project.create');
        }

        return view('report.index', compact('checklist', 'project'));
    }

    public function assetsummary(Asset $asset)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $asset->load('checklists');
        $asset->load('functionaltests');
        // return $asset;
        $pagetitle = "Asset Detail";


        return view('report.assetsummary', compact('asset', 'project'));
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

    public function checklistdetailreport()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $query = DB::table('assets')->where('assets.team_id','=',Auth::user()->currentTeam->id)
            ->join('checklists', 'assets.id', '=', 'checklists.asset_id')
            ->select('assets.id','assets.asset_type','assets.asset_tag','assets.asset_status','checklists.asset_id','checklists.checklist_title','checklists.checklist_status','checklists.checklist_contractor')           
            ->get();

        // return $query;
        return view('report.checklistdetailbytag', compact('project', 'query'));

    }

    public function checklistsummaryreport()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $alist = Asset::where('team_id', Auth::user()->currentTeam->id)->pluck('asset_type');
        $uniquelist= $alist->unique();
        $query = [];

        $totalassetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $totalassetssum = Asset::where('team_id', Auth::user()->currentTeam->id)->sum('asset_status');
        if($totalassetscount>0){
           $totalassetstatusraw = ($totalassetssum/$totalassetscount); 
       }else{
        $totalassetstatusraw = 0;
       }
        
        $totalassetsstatus = number_format($totalassetstatusraw, 2);

        //update the project
        $project->project_percent_complete = $totalassetsstatus;
        $project->update();

        foreach ($uniquelist as $ulist) {
            $assetcount = Asset::where('team_id', Auth::user()->currentTeam->id)->where('asset_type', $ulist)->count();
            $assetsum = Asset::where('team_id', Auth::user()->currentTeam->id)->where('asset_type', $ulist)->sum('asset_status');            
            if($assetcount > 0){
                $assetstatusraw = ($assetsum/$assetcount);
            }else{
                $assetstatusraw = 0;
            }
            $assetstatus = number_format($assetstatusraw, 2);
            $query[] = ['asset_type'=> $ulist, 'asset_count'=>$assetcount, 'asset_status'=>$assetstatus];
        }

        
        return view('report.checklistsummaryreportbytag', compact('project', 'query', 'totalassetscount', 'totalassetsstatus'));

    }

    public function checklistsummaryreportprint()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $alist = Asset::where('team_id', Auth::user()->currentTeam->id)->pluck('asset_type');
        $uniquelist= $alist->unique();
        $query = [];

        $totalassetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $totalassetssum = Asset::where('team_id', Auth::user()->currentTeam->id)->sum('asset_status');
        $totalassetstatusraw = ($totalassetssum/$totalassetscount);
        $totalassetsstatus = number_format($totalassetstatusraw, 2);

        foreach ($uniquelist as $ulist) {
            $assetcount = Asset::where('team_id', Auth::user()->currentTeam->id)->where('asset_type', $ulist)->count();
            $assetsum = Asset::where('team_id', Auth::user()->currentTeam->id)->where('asset_type', $ulist)->sum('asset_status');
            $assetstatusraw = ($assetsum/$assetcount);
            $assetstatus = number_format($assetstatusraw, 2);
            $query[] = ['asset_type'=> $ulist, 'asset_count'=>$assetcount, 'asset_status'=>$assetstatus];
        }

        
        return view('report.checklistsummaryreportbytag-print', compact('project', 'query', 'totalassetscount', 'totalassetsstatus'));

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
