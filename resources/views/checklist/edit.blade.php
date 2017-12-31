@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
        <!-- <div class="col-md-3">
          <div class="panel panel-success">
          <div class="panel-heading">
            <h3 class="panel-title">{{ $project->project_title }}</h3>
          </div>
            <div class="panel-body">
                <p><img src="/storage/upload/images/{{ $project->thumbnail }}" class="img-rounded" alt="Project Image" width="100%"></p>
                <p>
                  {{ $project->project_notes }}
                </p>
                <p><a class="btn btn-success btn-sm pull-right" href="/home" role="button">Project Home &raquo;</a></p>         
            </div>  
          </div>
        </div> -->
      
      <div class="col-md-12"> <!-- Main Panel Start -->
          <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Complete Checklist
              <a class="pull-right" href="/home"><i class="fa fa-home"></i>  |  </a>
              @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                <a class="pull-right" href="/checklist/{{ $checklist->id }}/edit" role="button">  <i class="fa fa-pencil"></i>  |  </a>  
              @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                <a class="pull-right" href="/checklist/{{ $checklist->id }}/edit" role="button">  <i class="fa fa-pencil"></i>  |  </a>
              @endif                
              <a class="pull-right" href="/report/checklist/{{ $checklist->id }}"><i class="fa fa-print"></i>  |  </a>
            </h3> 
          </div>         
            <div class="panel-body">
              <div class="row"> <!-- Top Row -->
                <div class="col-md-8">
                  <h3><u>Checklist:</u> {{ $checklist->checklist_tag }}</h3>
                  <ul style="list-style-type:circle">
                    <li><strong>Asset:</strong> {{ $checklist->asset->asset_tag }}</li>
                    <li><strong>Checklist Name:</strong> {{ $checklist->checklist_title }}</li>
                    <li><strong>Checklist Type:</strong> {{ $checklist->checklist_type }}</li>
                    <li><strong>Checklist Contrator:</strong> {{ $checklist->checklist_contractor }}</li>
                    <li><strong>Status:</strong> {{ $checklist->checklist_status }}</li>
                  </ul>
                </div>
                <div class="col-md-4">
                <h4>Checklist Notes</h4>
                  <p>
                    {{ $checklist->checklist_notes}}
                  </p>
                </div>
              </div> <!-- Top Row Ends -->
              <hr>
              <div class="row"> <!-- Bottom Row -->
                @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                  @include('shared.checklist_cxa')
                @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                  @include('shared.checklist_cxa')
                @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == $checklist->checklist_contractor)
                  @include('shared.checklist_contractor')
                @else
                  @include('shared.checklist_viewonly')
                @endif
              </div> <!-- Bottom Row Ends  -->                                        
            </div>
          </div>
        </div> <!-- Main Panel End -->
        </div>
      </div>
    </div>
</home>
@endsection