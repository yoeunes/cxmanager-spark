<?php

namespace App\Http\Controllers;

use App\Globaltemplate;
use Illuminate\Http\Request;
use Auth;
use App\Project;
use App\Asset;
use App\Assettype;
use App\Checklist;
use App\Checklisttemplate;
use App\Questiontemplate;
use App\Functionaltesttemplate;
use App\Functionaltestquestiontemplate;
use App\Issue;
use DB;

class GlobaltemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();

        $assettypes = Assettype::get();

        return view('globaltemplate.index', compact('assettypes', 'project', 'issuescount','assetscount','checklistscount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Globaltemplate  $globaltemplate
     * @return \Illuminate\Http\Response
     */
    public function show($templateid)
    {
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();

        $template = Assettype::where( 'id', $templateid )->first();
        $template->load('checklisttemplates.questiontemplates', 'functionaltesttemplates.functionaltestquestiontemplates');
       
        // return $template;
        
        return view('globaltemplate.show', compact('template', 'project', 'issuescount','assetscount','checklistscount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Globaltemplate  $globaltemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(Globaltemplate $globaltemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Globaltemplate  $globaltemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Globaltemplate $globaltemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Globaltemplate  $globaltemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Globaltemplate $globaltemplate)
    {
        //
    }
}
