@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Issues: 
        <small>{{ $pagetitle }}</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="issue">Issues</a></li>
        <li class="active">{{ $pagetitle }}</li>
      </ol>
@stop

@section('content')             
    <!-- Main content -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-body">
              <table id="example2" class="display">
                <thead>                  
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                    <th></th>
                    <th></th>  
                    @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                    <th></th>
                    <th></th>
                    @endif
                  </tr>                 
                </thead>
                <tbody>
                  @foreach ( $projissues as $issue )
                    <tr>
                      <td>{{ $issue->id }}</td>
                      <td><a href="/issue/show/{{ $issue->id }}">{{ $issue->issue_title }}</a></td>
                      <td>{{ $issue->issue_status }}</td>
                      @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                      <td><a href="/issue/{{ $issue->id }}/edit" role="button" ><i class="fa fa-pencil"></i> </a></td>
                      <td> 
                        <form action="{{ url('issue/'.$issue->id) }}" method="POST" class="form-inline">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}

                          <button type="submit" id="delete-issue-{{ $issue->id }}" class="btn btn-sm btn-link">
                          <i class="fa fa-btn fa-trash"></i> </button>
                        </form>
                      </td>
                      @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                      <td><a href="/issue/{{ $issue->id }}/edit" role="button" ><i class="fa fa-pencil"></i> </a></td>
                      <td> 
                        <form action="{{ url('issue/'.$issue->id) }}" method="POST" class="form-inline">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}

                          <button type="submit" id="delete-issue-{{ $issue->id }}" class="btn btn-sm btn-link">
                          <i class="fa fa-btn fa-trash"></i> </button>
                        </form>
                      </td>
                      @endif
                    </tr>
                    @endforeach 
                  </tbody>
                <tfoot>                  
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                    <th></th>
                    <th></th>  
                    @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                    <th></th>
                    <th></th>
                    @endif
                  </tr>                 
                </tfoot>
              </table>
              <hr>
              <p>
                <a class="btn btn-info btn-sm" href="/issue" role="button"><i class="fa fa-info"></i> Unresolved</a>
                <a class="btn btn-info btn-sm" href="/issue/resolved" role="button"><i class="fa fa-info"></i> Resolved</a>
                <a class="btn btn-info btn-sm" href="/issue/all" role="button"><i class="fa fa-info"></i> All</a>
                <a class="btn btn-info btn-sm" href="/issue/detailed" role="button"><i class="fa fa-info"></i> Detailed</a>
                <a class="btn btn-success btn-sm pull-right" href="/home" role="button"><i class="fa fa-times"></i> Close</a>
              </p>
            </div><!-- /.panel-body -->
          </div><!-- /.panel-primary -->        
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('footer')
  @include('adminlte::partials.footer')
@endsection

@section('page_scripts')
<script>
  $(function () {
    $('#example2').DataTable({
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