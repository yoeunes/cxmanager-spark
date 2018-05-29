<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Validator;

use DB;

use Auth;

use App\Project;

use App\Asset;

use App\Assettype;

use App\Checklist;

use App\Issue;

use App\Checklisttemplate;

use App\Checklistquestiontemplate;

use App\Checklistquestion;

use App\Functionaltest;

use App\Functionaltestquestion;

class AssetController extends Controller
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

        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
        $assets = Asset::where('team_id', Auth::user()->currentTeam->id)->get();
        $pagetitle = "All Assets";

        // return $assets;
    
        return view('asset.index', compact('project', 'pagetitle', 'assets', 'issuescount', 'assetscount', 'checklistscount'));
    }

    
    public function create()
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $assettypes = DB::select('select * from assettypes');
        $pagetitle = "Create Asset";

        return view('asset.create', compact('project', 'pagetitle', 'assettypes'));
    }

    
    public function store(Request $request)
    {
        // dd(request()->all());

        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();

        $this->validate(request(), [
            'asset_number' => 'max:255',
            'asset_title' => 'required | max:255',
            'asset_tag' => 'required | max:255',
            'asset_type' => 'required|max:255',
            'asset_notes' => 'max:1000',
            'additional_tags' => 'max:2500',
        ]);
        // Save the first asset from form values and get the new asset id
        // dd(request()->all());


        $asset = new Asset;
        $asset->team_id = Auth::user()->currentTeam->id;
        $asset->asset_number = $request->Input('asset_number');
        $asset->asset_title = $request->Input('asset_title');
        $asset->asset_type = $request->Input('asset_type');
        $asset->asset_tag = $request->Input('asset_tag');
        $asset->asset_status = "0.00";
        $asset->asset_notes = $request->Input('asset_notes');
        $asset->thumbnail = 'asset_thumbnail.png';
        $asset->save();

        //add checklists to the asset
        $assetid = DB::getPdo()->lastInsertId();        
        $assettypeid = Assettype::where('type_name', $asset->asset_type)->value('id');
        $assettag = $asset->asset_tag;
        $asset->addChecklists( $assetid, $assettypeid, $assettag );

        //add functional tests to the asset
        if( $request->Input('include_fpt')){
            $asset->addFunctionaltests( $assetid, $assettypeid, $assettag );
        }

        if( $request->Input('additional_tags')) {
            $additional_tags = $request->Input('additional_tags');
            $moreassets = explode(',', $additional_tags);
            $lastassetnumber =  $asset->asset_number;

            foreach ($moreassets as $moreasset){
                $ast = new Asset;
                $ast->team_id = Auth::user()->currentTeam->id;
                $ast->asset_number = $lastassetnumber + 1;
                $ast->asset_title = $request->Input('asset_title');
                $ast->asset_type = $request->Input('asset_type');
                $ast->asset_tag = $moreasset;
                $ast->asset_status = "0.00";
                $ast->asset_notes = $request->Input('asset_notes');
                $ast->thumbnail = 'asset_thumbnail.png';
                $ast->save();

                //add checklists to the asset
                $assetid = DB::getPdo()->lastInsertId();        
                $assettypeid = Assettype::where('type_name', $ast->asset_type)->value('id');
                $assettag = $ast->asset_tag;
                $ast->addChecklists( $assetid, $assettypeid, $assettag );

                //add functional tests to the asset
                if( $request->Input('include_fpt')){
                $asset->addFunctionaltests( $assetid, $assettypeid, $assettag );
        }
            }
        }

        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
        $assets = Asset::where('team_id', Auth::user()->currentTeam->id)->get();
        $pagetitle = "All Assets";

        // return $assets;
    
        return view('asset.index', compact('project', 'pagetitle', 'assets', 'issuescount', 'assetscount', 'checklistscount'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $asset->load('checklists');
        $asset->load('functionaltests');
        // return $asset;
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->where('asset_id', $asset->id)->count();
        $fptscount = Functionaltest::where('team_id', Auth::user()->currentTeam->id)->where('asset_id', $asset->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->where('asset_id', $asset->id)->count();
        $assetissues = Issue::where('team_id', Auth::user()->currentTeam->id)->where('asset_id', $asset->id)->get();
        $pagetitle = "Asset Detail";


        return view('asset.show', compact('asset', 'project', 'assetissues', 'pagetitle','issuescount','fptscount','checklistscount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {      
        $asset->update($request->all());
        
        //set status of asset
        $numerator = Checklist::where('asset_id', $asset->id )->where('checklist_status', '100.00')->count();
        $denominator = $asset->checklists->count();
        $percentage = ($numerator / $denominator ) * 100;
        $asset->asset_status = number_format($percentage, 2);
        $asset->update();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $checklists = Checklist::where('asset_id', $asset->id)->get();
        foreach ($checklists as $checklist) {
            Checklistquestion::where('checklist_id', $checklist->id)->delete();
            $checklist->delete();
        }

        $functionaltests = Functionaltest::where('asset_id', $asset->id)->get();
        foreach ($functionaltests as $functionaltest) {
            Functionaltestquestion::where('functionaltest_id', $functionaltest->id)->delete();
            $functionaltest->delete();
        }

        $asset->delete();

        return redirect('/asset');
    }
}
