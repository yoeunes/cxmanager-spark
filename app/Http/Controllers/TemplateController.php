<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Auth;

use App\Assettype;

use App\Project;

use App\Issue;

use App\Checklist;

use App\Asset;

use App\Template;

class TemplateController extends Controller
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
        $assettypes = Assettype::get();
        $projecttemplates = Template::where('project_id', $project->id)->get();
        $usertemplates = Template::where('user_id', Auth::user()->id)->get();
        $globaltemplates = Template::where('template_type', 'global')->get();
        $pagetitle = "Templates";

        // return $projecttemplates;

    	return view('template.index', compact('project', 'pagetitle', 'globaltemplates', 'projecttemplates', 'usertemplates', 'issuescount', 'assetscount', 'checklistscount'));
    }

    public function store(Request $request)
    {
        // dd(request()->all());
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();       
        $globaltemplate = Template::where('template_type','global')->whereNull('project_id')->whereNull('user_id')->where('status', 'active')->get();

        // return $globaltemplateids;
        foreach ($globaltemplate as $gtemplate) {
            if ( $request->Input('gtempl-'.$gtemplate->id)) {
                // print $gtemplate->template_name;
                $templ = new Template;                                          //add a new project template
                $templ->project_id = $project->id;
                $templ->template_name = $gtemplate->template_name;
                $templ->template_type = "project";
                $templ->assettype_id = $gtemplate->assettype_id;
                $templ->status = "active";
                $templ->save(); 

                $templateid = DB::getPdo()->lastInsertId();                     // get the id of the last template
                $assettypeid = $gtemplate->assettype_id;

                $templ->addChecklistTemplates($templateid, $assettypeid);       // add checklists to the new template
                $templ->addFunctionaltestTemplates($templateid, $assettypeid);  // add FPTs to the new template
                }
        }
        return back();

    }

    public function createblank(Request $request)
    {
        // dd(request()->all());

        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();
        $pagetitle = "Project Template";

        $templ = new Template;                                          //add a new project template
        $templ->project_id = $project->id;
        $templ->template_name = $request->Input('template_name');
        $templ->template_type = "project";
        $templ->status = "active";
        $templ->save(); 

        return back();
    }

    public function show(Template $template)
    {
        $project = Project::where('team_id', Auth::user()->currentTeam->id)->first();
        $issuescount = Issue::where('team_id', Auth::user()->currentTeam->id)->count();
        $assetscount = Asset::where('team_id', Auth::user()->currentTeam->id)->count();
        $checklistscount = Checklist::where('team_id', Auth::user()->currentTeam->id)->count();

        if($template->template_type == 'global'){
            $pagetitle = "Global Template";
        }
        elseif($template->template_type == 'user'){
            $pagetitle = "User Template";
        }
        else{
            $pagetitle = "Project Template";
        }

        // get template's checklists
        $template->load('checklisttemplate');
        $template->load('fpttemplate');

        // return $template;

        return view('template.show', compact('project','template','pagetitle','issuescount', 'assetscount', 'checklistscount'));
    }
}
