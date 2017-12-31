<?php

namespace App\Http\Controllers;

use App\Functionaltest;
use Illuminate\Http\Request;

use Storage;

use DB;

use Auth;

use App\Project;

use App\Funtionaltest;

use App\Functionaltestquestion;

use App\Asset;

use App\Issue;

use App\Checklist;

class FunctionaltestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Asset $asset)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        if ($project == "")
        {
            return view('project.create');
        }

        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
        $functionaltests = Functionaltest::where('asset_id', $asset->id)->get();

        foreach ($functionaltests as $fpt )
        {
            $fpt->load('functionaltestquestions');
            $fpt->load('asset');
        }

        if ( Auth::user()->roleOn( Auth::user()->currentTeam ) === 'owner') {
            return view('shared.fptfill_cxa', compact('project', 'functionaltests', 'issuescount', 'assetscount', 'checklistscount', 'asset'));
        }elseif ( Auth::user()->roleOn( Auth::user()->currentTeam ) === 'controls') {
            return view('shared.fptfill_contractor', compact('project', 'functionaltests', 'issuescount', 'assetscount', 'checklistscount', 'asset'));
        }elseif ( Auth::user()->roleOn( Auth::user()->currentTeam ) === 'controls') {
            return view('shared.fptfill_contractor', compact('project', 'functionaltests', 'issuescount', 'assetscount', 'checklistscount', 'asset'));
        }else{
            return view('shared.fptfill_readonly', compact('project', 'functionaltests', 'issuescount', 'assetscount', 'checklistscount', 'asset'));
        }       
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
     * @param  \App\Functionaltest  $functionaltest
     * @return \Illuminate\Http\Response
     */
    public function show(Functionaltest $functionaltest)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $asset = Asset::where('id', $functionaltest->asset_id )->first();
        $functionaltest->load('functionaltestquestions');
        // return compact('functionaltest', 'asset');

        return view('functionaltest.show', compact('functionaltest', 'project','asset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Functionaltest  $functionaltest
     * @return \Illuminate\Http\Response
     */
    public function edit(Functionaltest $functionaltest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Functionaltest  $functionaltest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Functionaltest $functionaltest)
    {   
        // dd(request()->all());
        $functionaltest->update($request->all());

        $questions = Functionaltestquestion::where('functionaltest_id', $functionaltest->id)->get();

        // Save Questions Data
        foreach ($questions as $question)
        {
                if ( $request->Input($question->id.'-control_sequence')) {
                    $question->control_sequence = $request->Input($question->id.'-control_sequence');
                }
                if ( $request->Input($question->id.'-question_text')) {
                    $question->question_text = $request->Input($question->id.'-question_text');
                }
                if ( $request->Input($question->id.'-answer_design')) {
                    $question->answer_design = $request->Input($question->id.'-answer_design');
                }
                if ( $request->Input($question->id.'-answer_installed')) {
                    $question->answer_installed = $request->Input($question->id.'-answer_installed');
                }
                if ( $request->Input($question->id.'-answer_accepted')) {
                    $question->answer_accepted = $request->Input($question->id.'-answer_accepted');
                    $question->question_status = 100;
                }
                if  ($request->Input($question->id.'-answer_comment')) {
                    $question->answer_comment = $request->Input($question->id.'-answer_comment');
                }

                $question->save();                
        }

        // Update functional test status
        
            $numerator = Functionaltestquestion::where('id', $functionaltest->id)->where('question_status', 100 )->count();
            $denominator = Functionaltestquestion::where('id', $functionaltest->id)->count();
            $percentage = ($numerator/$denominator) * 100;
            $functionaltest->functionaltest_status = number_format($percentage, 2); 
            $functionaltest->update();

        //update asset status
            // $asset = Asset::where('id', $checklist->asset_id)->first();
            // $assetstatusdenum = Checklist::where('asset_id', $checklist->asset_id)->count();
            // $assetstatusnum = Checklist::where('asset_id', $checklist->asset_id)->where('checklist_status', 100)->count();
            // $assetstatus = ($assetstatusnum/$assetstatusdenum) * 100;
            // $asset->asset_status = number_format($assetstatus, 2);
            // $asset->update();
        // return $asset->asset_status;

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Functionaltest  $functionaltest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Functionaltest $functionaltest)
    {
        //
    }
}
