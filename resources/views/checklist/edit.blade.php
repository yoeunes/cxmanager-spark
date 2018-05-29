@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Checklist: 
        <small>{{ $pagetitle }}</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/asset/show/{{ $checklist->asset->id }}">Asset</a></li>
        <li class="active">{{ $pagetitle }}</li>
      </ol>
@stop

@section('content')
        <div class="row">     
      <div class="col-md-12"> <!-- Main Panel Start -->
          <div class="box box-primary">
                 
            <div class="box-body">
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
@endsection

@section('footer')
  @include('adminlte::partials.footer')
@endsection

@section('page_scripts')
  <!-- page script -->
<script>
  $(function () {
    $('#checklisttable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>
@endsection