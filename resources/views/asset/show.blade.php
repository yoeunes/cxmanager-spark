@extends('adminlte::page')

@section('title', 'CxMNGR - Asset Profile')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Asset: 
        <small>{{ $pagetitle }}</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/asset">Assets</a></li>
        <li class="active">{{ $pagetitle }}</li>
      </ol>
@stop

@section('content')
<div class="row">
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="img-responsive" src="/storage/upload/images/equipment_placeholder.png" alt="User profile picture">

        <h3 class="profile-username text-center">{{ $asset->asset_tag }}</h3>
        <p class="text-muted text-center">{{ $asset->asset_title }}</p>

        <!-- <p class="text-muted text-center">Software Engineer</p> -->

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b># of Checklists</b> <a class="pull-right">{{ $checklistscount }}</a>
          </li>
          <li class="list-group-item">
            <b># of Functional Tests</b> <a class="pull-right">{{ $fptscount }}</a>
          </li>
          <li class="list-group-item">
            <b># of Issues</b> <a class="pull-right">{{ $issuescount }}</a>
          </li>
        </ul>

        <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- About Me Box -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Asset Notes</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">

        <p class="text-muted">
          {{ $asset->asset_notes }}
        </p>              
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div> 

  <div class="col-md-9"> <!-- Main Panel Start -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#checklists" data-toggle="tab">Checklists</a></li>
          <li><a href="#fpts" data-toggle="tab">Functional Tests</a></li>
          <li><a href="#issues" data-toggle="tab">Issues</a></li>
          <li><a href="#reports" data-toggle="tab">Reports</a></li>
          <li><a href="#documents" data-toggle="tab">Documents</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="checklists">
            <!-- Checklists -->
                <table id="table1" class="table table-striped">
                  <thead>                   
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Contractor</th>
                      <th>Status</th>
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
                  @foreach ( $asset->checklists as $checklist )
                    <tr>
                      <td>{{ $checklist->checklist_category_order}}</td>
                      <td class="text"><a href="/checklist/{{ $checklist->id }}/edit">{{ $checklist->checklist_title }}</a></td>
                      <td class="text">{{ $checklist->checklist_contractor }}</td>
                      <td class="text">{{ $checklist->checklist_status }} %</td>
                      @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                        <td><a href="/checklist/{{ $checklist->id }}" role="button" ><i class="fa fa-pencil"></i> </a></td>
                        <td> 
                          <form action="{{ url('checklist/'.$checklist->id) }}" method="POST" class="form-inline">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="submit" id="delete-checklist-{{ $checklist->id }}" class="btn btn-link">
                            <i class="fa fa-btn fa-trash"></i></button>
                          </form>
                        </td>
                      @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                        <td><a href="/checklist/{{ $checklist->id }}" role="button" ><i class="fa fa-pencil"></i> </a></td>
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
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="fpts">
                <table id="table2" class="table table-striped">
                  <thead>
                  <th>#</th>
                  <th>Functional Test</th>
                  <th>Status</th>
                  @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                    <th><a href="/functionaltest/{{ $asset->id }}/fill">  <i class="fa fa-check-square-o"></i></a></th>
                    <th><a href="#">  <i class="fa fa-plus"></i></a></th>
                  @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                    <th><a href="/functionaltest/{{ $asset->id }}/fill">  <i class="fa fa-check-square-o"></i></a></th>
                    <th><a href="#">  <i class="fa fa-plus"></i></a></th>
                  @endif 
                </thead>
                <tbody>
                  @foreach( $asset->functionaltests as $fpt )
                    <tr>
                      <td>{{ $fpt->functionaltest_category_order }}</td>
                      <td><a href="/functionaltest/{{ $fpt->id }}">{{ $fpt->functionaltest_title }}</a></td>
                      <td>{{ $fpt->functionaltest_status }} %</td>
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
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="issues">
            <!-- The Issues -->
                <table id="table3" class="table table-striped">
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
                  @foreach ( $assetissues as $issue )
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
                </table>
            <!-- /.box -->
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="reports">
            <p>Reports table to come</p>
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="documents">
            <p>Asset documents to come...</p>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div> <!-- Main Panel End -->
</div>
<!-- Edit Asset Modal -->
<div id="editAssetModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Asset</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/asset/{{ $asset->id }}">
               {{ method_field('PATCH')}}
               {{ csrf_field() }}

               <input type="hidden" name="team_id" value="{{ $asset->team_id }}"> 

               <input type="hidden" name="asset_id" value="{{ $asset->space_id }}"> 

                <div class="form-group">
                <label for="asset_number" class="col-sm-2 control-label">Asset #</label>
                <div class="col-sm-10">
                <input type="text" name="asset_number" id="asset_number" class="form-control" value="{{ $asset->asset_number }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="asset_title" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                <input type="text" name="asset_title" id="asset_title" class="form-control" value="{{ $asset->asset_title }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="asset_type" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                <input type="text" name="asset_type" id="asset_type" class="form-control" value="{{ $asset->asset_type }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="asset_tag" class="col-sm-2 control-label">Tag</label>
                <div class="col-sm-10">
                <input type="text" name="asset_tag" id="asset_tag" class="form-control" value="{{ $asset->asset_tag }}"></input>
                </div>
                </div>

                <div class="form-group">
                  <label for="asset_notes" class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                  <textarea name="asset_notes" class="form-control" id="asset_notes" rows="5">{{ $asset->asset_notes }}</textarea>
                  </div>
                </div>

                <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary pull-right">Update</button>
                </div>
                </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal End -->

<!-- Add Checklist to Asset Modal -->
<div id="addChecklistModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Checklist</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/checklist/{{ $asset->id }}/add">
               {{ csrf_field() }}

               <input type="hidden" name="team_id" value="{{ $asset->team_id }}"> 

               <input type="hidden" name="asset_id" value="{{ $asset->id }}"> 

               <div class="form-group">
               <label for="checklist_title" class="col-sm-2 control-label">Title</label>
               <div class="col-sm-10">
               <input type="text" name="checklist_title" id="checklist_title" class="form-control" placeholder="Enter Title for checklist" required></input>
               </div>
               </div>

               <div class="form-group">
               <label for="checklist_tag" class="col-sm-2 control-label">Tag</label>
               <div class="col-sm-10">
               <input type="text" name="checklist_tag" id="checklist_tag" class="form-control" placeholder="Enter Tag" required></input>
               </div>
               </div>

               <div class="form-group">
               <label for="checklist_contractor" class="col-sm-2 control-label">Contractor</label>
               <div class="col-sm-10">
               <input type="text" name="checklist_contractor" id="checklist_contractor" class="form-control" placeholder="eg. Mechanical Contractor" required></input>
               </div>
               </div>

               <div class="form-group">
               <label for="checklist_status" class="col-sm-2 control-label">Status</label>
               <div class="col-sm-10">
               <input type="text" name="checklist_status" id="checklist_status" class="form-control" placeholder="eg. Not Started" required></input>
               </div>
               </div>

               <div class="form-group">
               <label for="checklist_type" class="col-sm-2 control-label">Type</label>
               <div class="col-sm-10">
               <input type="text" name="checklist_type" id="checklist_type" class="form-control" placeholder="Prefunctional Checklists?" required></input>
               </div>
               </div>

               <div class="form-group">
               <label for="checklist_category_order" class="col-sm-2 control-label">Order</label>
               <div class="col-sm-10">
               <input type="text" name="checklist_category_order" id="checklist_category_order" class="form-control" placeholder="Enter Number" required></input>
               </div>
               </div>

               <div class="form-group">
                 <label for="checklist_notes" class="col-sm-2 control-label">Notes</label>
                   <div class="col-sm-10">
                 <textarea name="checklist_notes" class="form-control" id="checklist_notes" rows="5"></textarea>
                 </div>
               </div>

               <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10">
               <button type="submit" class="btn btn-primary pull-right">Add</button>
               </div>
               </div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal End -->
@endsection

@section('footer')
  @include('adminlte::partials.footer')
@endsection