<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Validator;

use Storage;

use DB;

use Auth;

use App\Project;

use App\Asset;

use App\Template;

use App\Checklisttemplate;

use App\Checklistquestiontemplate;

use App\Functionaltesttemplate;

class FunctionaltesttemplateController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');

        //$this->middleware('subscribed');
    }
    
    public function createblank(Request $request, Template $template )
    {
    	// dd($request->all());
    	$project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $pagetitle = "Create Functional Test Template";

        $this->validate(request(), [
            'functionaltest_title' => 'required | max:255',
            'functionaltest_tag' => 'max:255',
            'functionaltest_contractor' => 'required | max:255',
            'functionaltest_type' => 'max:255',
            'functionaltest_category_order' => 'required | max:255',
            'functionaltest_notes' => 'max:1024',
        ]);

        $fpttemp = new Functionaltesttemplate;
        $fpttemp->team_id = Auth::user()->currentTeam->id;
        $fpttemp->template_id = $request->Input('template_id');
        $fpttemp->assettype_id = 0;
        $fpttemp->functionaltest_title = $request->Input('functionaltest_title');
        $fpttemp->functionaltest_contractor = $request->Input('functionaltest_contractor');
        $fpttemp->functionaltest_status = 0;
        $fpttemp->functionaltest_type = $request->Input('functionaltest_type');
        $fpttemp->functionaltest_category_order = $request->Input('functionaltest_category_order');
        $fpttemp->functionaltest_notes = $request->Input('functionaltest_notes');
        $fpttemp->save();

        return back();
    }
}
