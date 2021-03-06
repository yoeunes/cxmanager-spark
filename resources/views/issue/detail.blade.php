@extends('spark::layouts.app')

@section('scripts')
    <link href='https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
          $('#issuetable').DataTable();
      } );
    </script>
@endsection

@section('content')
<home :user="user" inline-template>
  <div class="container">
      <!-- Application Dashboard -->
    <div class="row">
        <div class="col-md-9">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">{{ $pagetitle }}
              @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                <a href="/report/{{ $reporttype }}" class="pull-right"> <i class="fa fa-print"> | </i></a>
                <a href="/issue/create" class="pull-right"><i class="fa fa-plus"> | </i></a></h3>  
              @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                <a href="/report/{{ $reporttype }}" class="pull-right"> <i class="fa fa-print"> | </i></a>
                <a href="/issue/create" class="pull-right"><i class="fa fa-plus"> | </i></a></h3>
                @endif 
                
            </div>
            <div class="panel-body">                
              <table id="issuetable" class="display">
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
                    <tr>
                      <td></td>
                    @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                    <th></th>
                    <th></th>  
                    @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                    <th></th>
                    <th></th>
                    @endif
                      <td colspan="2">
                        <div>
                          <strong>Description: </strong> <textarea class="form-control" rows="2">{{ $issue->issue_description }}</textarea>
                          <strong>Recommendation: </strong> <textarea class="form-control" rows="2">{{ $issue->issue_recommendation }}</textarea>
                        </div>
                      </td>
                  </tr>
                    @endforeach 
                  </tbody>
                </table>
                <hr>
                <p>
                  <a class="btn btn-info btn-sm" href="/issue" role="button"><i class="fa fa-info"></i> Unresolved</a>
                  <a class="btn btn-info btn-sm" href="/issue/resolved" role="button"><i class="fa fa-info"></i> Resolved</a>
                  <a class="btn btn-info btn-sm" href="/issue/all" role="button"><i class="fa fa-info"></i> All</a>
                  <a class="btn btn-info btn-sm" href="/issue/detailed" role="button"><i class="fa fa-info"></i> Detailed</a>
                  <a class="btn btn-success btn-sm pull-right" href="/home" role="button"><i class="fa fa-times"></i> Close</a>
                </p>
          </div> <!-- panel body end -->
        </div> <!-- panel end -->
      </div> <!-- column end -->        
      @include('shared.leftmenu') 
    </div> <!-- row end -->
  </div> <!-- container end -->
</home>
@endsection