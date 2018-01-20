@extends('spark::layouts.app')

@section('scripts')
    <link href='https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
          $('#checklisttable').DataTable();
      } );
    </script>
@endsection

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
        <div class="col-md-3">
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
          </div> <!-- Project Info End -->

          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Checklist Stats</h3>
            </div>
            <div class="panel-body">
                <ul style="list-style-type:circle" >
                  <li><a href="#"><Strong>Air Handling Units:</Strong></a> 20</li>
                  <li><a href="#"><Strong>Exhaust Fans:</Strong></a> 12</li>
                  <li><a href="#"><Strong>Heat Pumps:</Strong></a> 15</li>
                  <li><a href="#"><Strong>Unit Heaters:</Strong></a> 10</li>
                  <li><a href="#"><Strong>Generators:</Strong></a> 2</li>
                  <li><a href="#"><Strong>Panelboards:</Strong></a> 30</li>
                  <li><a href="#"><Strong>Dry Transformers:</Strong></a> 10</li>
                  <li><a href="#"><Strong>Water Heaters:</Strong></a> 15</li>
                  <li><a href="#"><Strong>Transfer Switch:</Strong></a> 3</li>
                  <li><a href="#"><Strong>Sumps Pumps:</Strong></a> 8</li>
                </ul> 
              </div>     
          </div>
        </div> <!-- Left Panel End -->

        <div class="col-md-9">
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
                    <th></th>
                    <th></th>
                  </tr>                 
                </thead>
                <tbody>
                @foreach ( $checklists as $checklist )
                  <tr>
                    <td>{{ $checklist->checklist_tag }}</td>
                    <td><a href="/checklist/{{ $checklist->id }}/edit">{{ $checklist->checklist_title }}</a></td>
                    <td>{{ $checklist->checklist_type }}</td>
                    <td>{{ $checklist->checklist_status }}</td>
                    <td><a href="/checklist/show/{{ $checklist->id }}" role="button" ><i class="fa fa-pencil"></i> </a></td>
                    <td class="text"> 
                      <form action="{{ url('checklist/'.$checklist->id) }}" method="POST" class="form-inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" id="delete-checklist-{{ $checklist->id }}" class="btn btn-sm btn-default">
                        <i class="fa fa-btn fa-trash"></i></button>
                      </form>
                    </td>
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