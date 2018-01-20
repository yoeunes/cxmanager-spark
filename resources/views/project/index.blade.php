@extends('spark::layouts.app')

@section('scripts')
    <link href='https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
          $('#projectstable').DataTable();
      } );
    </script>
@endsection

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
        <div class="col-md-12">
          <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Projects
              <a href="/project/create" class="pull-right" role="button" ><i class="fa fa-plus"></i> </a>
            </h3>
          </div>
            <div class="panel-body">
              <table id="projectstable" class="display">
                <thead>
                  
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>% Complete</th>
                    <th></th>
                    <th></th>
                  </tr>                 
                </thead>
                <tbody>
                @foreach ( $projects as $project )
                  <tr>
                    <td>{{ $project->id }}</td>
                    <td><a href="/home">{{ $project->project_title }}</a></td>
                    <td>{{ $project->project_status }}</td>
                    <td>{{ $project->project_percent_complete }}</td>
                    <td><a href="/project/{{ $project->id }}/edit" role="button" ><i class="fa fa-pencil"></i> </a></td>
                    <td> 
                      <form action="{{ url('project/'.$project->id) }}" method="POST" class="form-inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" id="delete-project-{{ $project->id }}" class="btn btn-sm btn-default">
                        <i class="fa fa-btn fa-trash"></i> </button>
                      </form>
                    </td>
                  </tr>
                @endforeach 
                </tbody>
              </table>
            </div>
          </div>
       </div>
      </div>
    </div>
</home>
@endsection
