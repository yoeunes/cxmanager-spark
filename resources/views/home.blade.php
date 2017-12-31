@extends('spark::layouts.app')

@section('scripts')
  {!! Charts::styles() !!}
@endsection

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
      <div class="row">
        <div class="col-md-9">
          <div class="panel panel-primary">
          @if($project)
            <div class="panel-heading">
              <h3 class="panel-title">About the Project
                @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                    <a href="/project/{{ $project->id }}/edit" class="pull-right"><i class="fa fa-pencil"></i></a></h3>  
                @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                <a href="/project/{{ $project->id }}/edit" class="pull-right"><i class="fa fa-pencil"></i></a></h3>
                @endif             
              </h3>
            </div>
            <div class="panel-body">
              
                <h3>{{ $project->project_title }}</h3>
                  <div class="row">      
                    <div class="col-md-6">                
                      <ul style="list-style-type:circle">
                        <li><strong>Project #:</strong> {{ $project->project_number }}</li>
                        <li><strong>Title:</strong> {{ $project->project_title }}</li>
                        <li><strong>Start Date:</strong> {{ Carbon\Carbon::parse($project->project_start_date)->format('m-d-Y') }}</li>
                        <li><strong>End Date</strong> {{ Carbon\Carbon::parse($project->project_end_date)->format('m-d-Y') }}</li>
                        <li><strong>% Complete:</strong> {{ $project->project_percent_complete }}</li>
                        <li><strong>No. of Issues:</strong> <a href="/issue">{{ $issuescount }}</a></li>
                        <li><strong>No. of Assets:</strong> <a href="/asset">{{ $assetscount }}</a></li>
                        <li><strong>No. of Checklists:</strong> <a href="/checklist">{{ $checklistscount }}</a></li>
                      </ul> 
                    </div>
                    <div class="col-md-6">
                      <img src="/storage/upload/images/{{ $project->thumbnail }}" class="img-rounded" width="100%">
                    </div>
                  </div>
                  <p>{{ $project->project_notes }}</p>             
              </div>
            @else
            <div class="panel-heading">
              <h3 class="panel-title">About the Project</h3>
              </h3>
            </div>
              <div class="panel-body">
                <p>Project details not yet entered. Enter it <a href="/project/create">here</a></p>               
              </div>                
            @endif
          </div>

          <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Summaries</h3>
          </div>
            <div class="panel-body">

              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Issues -  <span class="badge">{{ $issuescount }}</span><span><a class="pull-right" href="/issue" role="button"> <i class="fa fa-sign-in" aria-hidden="true"></i> </a></span>
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <center>
                            {!! $noofissueschart->html() !!}
                        </center>
                      <hr>
                        <center>
                            {!! $resolvedissueschart->html() !!}
                        </center>
                      <hr>
                        <center>
                          {!! $issueprioritieschart->html() !!}
                        </center>
                        <hr>
                      <p><a class="btn btn-success pull-right" href="/issue" role="button">Go to Issues &raquo;</a></p>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Assets -  <span class="badge">{{ $assetscount }}</span><span><a class="pull-right" href="/asset" role="button"> <i class="fa fa-sign-in" aria-hidden="true"></i> </a></span>
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      <hr>
                        <center>
                            {!! $assetchart->html() !!}
                        </center>
                      <hr>
                      <p><a class="btn btn-success pull-right" href="/asset" role="button">Go to Assets &raquo;</a></p>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Checklists -  <span class="badge">{{ $checklistscount }}</span><span><a class="pull-right" href="/asset" role="button"> <i class="fa fa-sign-in" aria-hidden="true"></i> </a></span>
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <center>
                            {!! $checklistchart->html() !!}
                        </center>
                      <hr>
                      <p><a class="btn btn-success pull-right" href="/checklist" role="button">Go to Checklists &raquo;</a></p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!---------------->          
       </div>

       @include('shared.leftmenu_2') 

      </div>
    </div>
</home>
<!-- End Of Main Application -->
{!! Charts::scripts() !!}
{!! $checklistchart->script() !!}
{!! $assetchart->script() !!}
{!! $noofissueschart->script() !!}
{!! $issueprioritieschart->script() !!}
{!! $resolvedissueschart->script() !!}
@endsection
