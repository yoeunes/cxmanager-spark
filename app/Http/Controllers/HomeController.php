<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Project;

use App\Team;

use App\User;

use App\Asset;

use App\Issue;

use App\Checklist;

use Charts;

use DB;

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

        // $this->middleware('subscribed');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show()
    {    
        // $assets = Asset::where('team_id', Auth::user()->currentTeam->id)->get();      
        // return $assets;
        // return Auth::user()->currentTeam->name;
        //return view('home');

        // $project->load('issues');
        // $project->load('assets');
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();

        // issue variables
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $designissuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_type', 'Design')->count();
        $constructionissuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_type', 'Construction')->count();
        $submittalissuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_type', 'Submittal')->count();
        $testingissuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_type', 'Testing')->count();
        $checklistissuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_type', 'Checklist')->count();
        $resolvedissuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_status', 'Resolved')->count();
        $unresolvedissuescount = $issuescount - $resolvedissuescount;
        $criticalpriorityissuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_priority', 'Critical')->count();
        $highpriorityissuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_priority', 'High')->count();
        $mediumpriorityissuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_priority', 'Medium')->count();
        $lowpriorityissuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('issue_priority', 'Low')->count();

        // asset variables
        $completedassetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->where('asset_status', 100)->count();
        $remainingassetscount = $assetscount - $completedassetscount ;
        if ($assetscount == 0 )
        {
            $assetspercentagecomplete = 0.0;
        }
        else
        {
            $assetspercentagecomplete = $completedassetscount * 100 / $assetscount;
        }
        

        // checklist variables
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount_mechanical = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor', 'mechanical')->count();
        $checklistscount_electrical = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor', 'electrical')->count();
        $checklistscount_plumbing = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor', 'plumbing')->count();
        $checklistscount_controls = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor', 'controls')->count();
        $checklistscount_testandbalance = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('checklist_contractor', 'tab')->count();
        
        $assetlist = DB::table('assets')->select('asset_type')->distinct()->get();
        // return $assetlist;
        $assetlistvalues = array();

        foreach ($assetlist as $alist)
        {
            $totalcount = Asset::where('team_id', Auth::user()->currentTeam->id)->where('asset_type', $alist->asset_type)->count();
            $completedcount = Asset::where('team_id', Auth::user()->currentTeam->id)->where('asset_type', $alist->asset_type)->where('asset_status','100')->count();
            array_push($assetlistvalues ,$alist, $totalcount, $completedcount);
        }

        // return $assetlistvalues;

        $checklistchart = Charts::create('bar', 'fusioncharts')
                    ->title('Checklist Data')
                    ->labels(['Mechanical', 'Electrical', 'Plumbing','Controls', 'T&B'])
                    ->colors(['#ff0000', '#0040ff', '#ff8000', '#ffbf00', '#ff00bf' ])
                    ->values([$checklistscount_mechanical,$checklistscount_electrical,$checklistscount_plumbing,$checklistscount_controls,$checklistscount_testandbalance])
                    ->dimensions(400,400);

        $noofissueschart = Charts::create('bar', 'fusioncharts')
                    ->title('# of Issues')
                    ->labels(['Design', 'Construction', 'Submittal','Testing', 'Checklist'])
                    ->colors(['#ff0000', '#0040ff', '#ff8000', '#ffbf00', '#ff00bf' ])
                    ->values([$designissuescount,$constructionissuescount,$submittalissuescount,$testingissuescount,$checklistissuescount])
                    ->dimensions(400,400);

        $issueprioritieschart = Charts::create('bar', 'fusioncharts')
                    ->title('Issue Priorities')
                    ->labels(['critical', 'high', 'medium','low'])
                    ->colors(['#ff0000', '#0040ff', '#ff8000', '#ffbf00' ])
                    ->values([$criticalpriorityissuescount,$highpriorityissuescount,$mediumpriorityissuescount,$lowpriorityissuescount])
                    ->dimensions(400,400);
                    
        $resolvedissueschart = Charts::create('percentage','justgage')
                    ->title('Resolved Issues')
                    ->elementLabel('Issues Resolved')
                    ->values([$resolvedissuescount,0,$issuescount])
                    ->dimensions(400,400);

        $assetchart = Charts::create('percentage','justgage')
                    ->title('Asset Data')
                    ->elementLabel('% complete')
                    ->values([$completedassetscount,0,$assetscount])
                    ->dimensions(400,400);

        return view('home', compact('project','issuescount', 'assetscount', 'checklistscount', 'assetspercentagecomplete'
            ), [ 'checklistchart' => $checklistchart, 'assetchart' => $assetchart, 'noofissueschart' => $noofissueschart
            , 'issueprioritieschart' => $issueprioritieschart, 'resolvedissueschart' => $resolvedissueschart
            , 'assetlistvalues' => $assetlistvalues ]);
    }
}
