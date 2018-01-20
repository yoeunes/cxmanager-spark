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
      <div class="col-md-9"> <!-- Main Panel Start -->
          <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Global Template
                <a class="pull-right" href="/home"><i class="fa fa-home"></i>  |  </a>
                @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                  <a class="pull-right" href="#" role="button" data-toggle="modal" data-target="#editAssetModal">  <i class="fa fa-pencil"></i>  |  </a>  
                @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                  <a class="pull-right" href="#" role="button" data-toggle="modal" data-target="#editAssetModal">  <i class="fa fa-pencil"></i>  |  </a>
                @endif                
                <a class="pull-right" href="#"><i class="fa fa-print"></i>  |  </a> 
            </h3> 
          </div>         
            <div class="panel-body">
              <div class="row"> <!-- Top Row -->
                <div class="col-md-12">
                  <h3><u>Asset Template:</u> {{ $template->type_name }}</h3>
                  <ul>
                    <li><strong>Asset Type ID:</strong> {{ $template->id }}</li>
                    <li><strong>Asset Type:</strong> {{ $template->type_name }}</li>
                  </ul>
                </div>               
              </div> <!-- Top Row Ends -->
              <h3>Prefunctional Checklists Templates</h3>
              <hr>
              <div class="row"> <!-- Bottom Row -->
                <div class="col-md-12">
                  <table id="checklisttable" class="display">
                    <thead>                   
                      <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Contractor</th>
                        @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                          <th></th>
                          <th><a href="#" role="button" data-toggle="modal" data-target="#addChecklistModal">  <i class="fa fa-plus"></i></a></th>
                        @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                          <th></th>
                          <th><a href="#" role="button" data-toggle="modal" data-target="#addChecklistModal">  <i class="fa fa-plus"></i></a></th>
                        @endif 
                        
                      </tr>                 
                    </thead>
                    <tbody>
                    @foreach ( $template->checklisttemplates as $checklist )
                      <tr>
                        <td>{{ $checklist->checklist_category_order}}</td>
                        <td class="text"><a href="#">{{ $checklist->checklist_title }}</a></td>
                        <td class="text">{{ $checklist->checklist_contractor }}</td>
                        @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                          <td><a href="#" role="button" ><i class="fa fa-pencil"></i> </a></td>
                          <td> 
                            <form action="{{ url('checklist/'.$checklist->id) }}" method="POST" class="form-inline">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}

                              <button type="submit" id="delete-checklist-{{ $checklist->id }}" class="btn btn-link">
                              <i class="fa fa-btn fa-trash"></i></button>
                            </form>
                          </td>
                        @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                          <td><a href="#" role="button" ><i class="fa fa-pencil"></i> </a></td>
                          <td> 
                            <form action="{{ url('checklist/'.$checklist->id) }}" method="POST" class="form-inline">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}

                              <button type="submit" id="delete-checklist-{{ $checklist->id }}" class="btn btn-link">
                              <i class="fa fa-btn fa-trash"></i></button>
                            </form>
                          </td>
                        @endif                        
                      </tr>
                    @endforeach 
                    </tbody>
                </table>
                <h3>Functional Performance Tests Templates</h3>
                <hr>
                  @if( $template->functionaltesttemplates == "")                  
                    <p>No functional test templates setup as yet. Add FPTs <a href="#">here</a></p>
                  @else
                  <table class="table">
                    <thead>
                      <th>#</th>
                      <th>Functional Test</th>
                      @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                      <th><a href="#">  <i class="fa fa-check-square-o"></i></a></th>
                      <th><a href="#">  <i class="fa fa-plus"></i></a></th>
                      @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                      <th><a href="#">  <i class="fa fa-check-square-o"></i></a></th>
                      <th><a href="#">  <i class="fa fa-plus"></i></a></th>
                    @endif 
                    </thead>
                    <tbody>
                      @foreach( $template->functionaltesttemplates as $fpt )
                        <tr>
                          <td>{{ $fpt->functionaltest_category_order }}</td>
                          <td><a href="#">{{ $fpt->functionaltest_title }}</a></td>
                          @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                          <td><a href="#"><i class="fa fa-pencil"></i> </a></td>
                          <td> 
                            <form action="{{ url('fpt/'.$fpt->id) }}" method="POST" class="form-inline">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}

                              <button type="submit" id="delete-fpt-{{ $fpt->id }}" class="btn btn-link">
                              <i class="fa fa-btn fa-trash"></i></button>
                            </form>
                          </td>
                        @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                          <td><a href="#"><i class="fa fa-pencil"></i> </a></td>
                          <td> 
                            <form action="#" method="POST" class="form-inline">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}

                              <button type="submit" id="delete-fpt-{{ $fpt->id }}" class="btn btn-link">
                              <i class="fa fa-btn fa-trash"></i></button>
                            </form>
                          </td>
                        @endif    
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @endif
                <hr>
                <p>
                  <a class="btn btn-default btn-sm" href="/globaltemplate" role="button"><i class="fa fa-back"></i> Global List</a>
                  <a class="btn btn-success btn-sm pull-right" href="/asset" role="button"><i class="fa fa-times"></i> Close</a></p> 
                </div>
              </div> <!-- Bottom Row Ends  -->                                        
            </div>
          </div>
        </div> <!-- Main Panel End -->
        @include('shared.leftmenu')
        </div>
      </div>
    </div>
</home>
@endsection