@extends('spark::layouts.app')

<!-- @section('scripts')
    <link href='https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
          $('#checklisttable').DataTable();
      } );
    </script>
@endsection -->

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">     
      <div class="col-md-12"> <!-- Main Panel Start -->
          <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Complete Checklist
              <a class="pull-right" href="/home"><i class="fa fa-home">  |  </i></a>
              @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                <a class="pull-right" href="/checklist/{{ $checklist->id }}/edit" role="button">  <i class="fa fa-pencil">  |  </i></a>  
              @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                <a class="pull-right" href="/checklist/{{ $checklist->id }}/edit" role="button">  <i class="fa fa-pencil">  |  </i></a>
              @endif                
              <a class="pull-right" href="/report/checklist/{{ $checklist->id }}"><i class="fa fa-print">  |  </i></a>
            </h3> 
          </div>         
            <div class="panel-body">
              <div class="row"> <!-- Top Row -->
                <div class="col-md-6">
                  <h3><u>Checklist:</u> {{ $checklist->checklist_tag }}</h3>
                  <ul style="list-style-type:circle">
                    <li><strong>Asset:</strong> {{ $checklist->asset->asset_tag }}</li>
                    <li><strong>Checklist Name:</strong> {{ $checklist->checklist_title }}</li>
                    <li><strong>Checklist Type:</strong> {{ $checklist->checklist_type }}</li>
                    <li><strong>Checklist Contrator:</strong> {{ $checklist->checklist_contractor }}</li>
                    <li><strong># of Comments:</strong> {{ $commentscount }}</li>
                    <li><strong>Status:</strong> {{ $checklist->checklist_status }}</li>
                  </ul>
                </div>
                <div class="col-md-6">
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