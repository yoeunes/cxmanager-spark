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
                    <a href="/project/{{ $project->id }}/edit" class="pull-right"><i class="fa fa-pencil"></i></a>  
                @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                <a href="/project/{{ $project->id }}/edit" class="pull-right"><i class="fa fa-pencil"></i></a>
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
            </div>
              <div class="panel-body">
                <p>Project details not yet entered. Enter it <a href="/project/create">here</a></p>               
              </div>                
            @endif
          </div><!-- panel end -->

          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Summaries</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-6">{!! $noofissueschart->html() !!}</div>
                <div class="col-md-6">{!! $issueprioritieschart->html() !!}</div><hr>
                <div class="col-md-6">{!! $checklistchart->html() !!}</div>
              </div>
              <hr>

              
            </div><!-- panel body end -->
          </div><!-- panel end -->
          <!---------------->          
       </div> <!-- main section end -->

       @include('shared.leftmenu_2') 

      </div><!-- row end -->
  </div><!-- container end -->
</home>
<!-- End Of Main Application -->
{!! Charts::scripts() !!}
{!! $checklistchart->script() !!}
<!-- {!! $assetchart->script() !!} -->
{!! $noofissueschart->script() !!}
{!! $issueprioritieschart->script() !!}
<!-- {!! $resolvedissueschart->script() !!} -->
@endsection
