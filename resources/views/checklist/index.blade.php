@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Checklist: 
        <small>{{ $pagetitle }}</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="checklist">Checklists</a></li>
        <li class="active">{{ $pagetitle }}</li>
      </ol>
@stop

@section('content')
        <!-- Application Dashboard -->
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Checklists<a href="/checklist/create/" class="pull-right"><i class="fa fa-plus"></i></a></h3>
              </div>
              <div class="panel-body">          
                <table id="checklisttable" class="display">
                  <thead>                 
                    <tr>
                      <th>Asset</th>
                      <th>Checklist Name</th>
                      <th>Type</th>
                      <th>Status</th>
                      @if(Auth::user()->ownsTeam(Auth::user()->currentTeam) || Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                          <th></th>
                          <th><a href="checklist/create" role="button"><i class="fa fa-plus"></i></a></th>                         
                      @endif
                    </tr>                 
                  </thead>
                  <tbody>
                  @foreach ( $checklists as $checklist )
                    <tr>
                      <td>{{ $checklist->checklist_tag }}</td>
                      <td><a href="/checklist/{{ $checklist->id }}/edit">{{ $checklist->checklist_title }}</a></td>
                      <td>{{ $checklist->checklist_type }}</td>
                      <td>{{ $checklist->checklist_status }}</td>
                      @if(Auth::user()->ownsTeam(Auth::user()->currentTeam) || Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                        <td><a href="/checklist/show/{{ $checklist->id }}" role="button" ><i class="fa fa-pencil"></i> </a></td>
                        <td class="text"> 
                          <form action="{{ url('checklist/'.$checklist->id) }}" method="POST" class="form-inline">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="submit" id="delete-checklist-{{ $checklist->id }}"  class="btn btn-sm btn-link">
                            <i class="fa fa-btn fa-trash"></i></button>
                          </form>
                        </td>
                      @endif
                    </tr>
                  @endforeach 
                  </tbody>
                </table>
                <hr>
                <p><a class="btn btn-success btn-sm pull-right" href="/home" role="button"><i class="fa fa-times"></i> Close</a></p> 
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
</home>
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