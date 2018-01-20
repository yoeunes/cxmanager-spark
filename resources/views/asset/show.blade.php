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
            <h3 class="panel-title">Asset Profile
                <a class="pull-right" href="/home"><i class="fa fa-home">  |  </i></a>
                @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                  <a class="pull-right" href="#" role="button" data-toggle="modal" data-target="#editAssetModal"><i class="fa fa-pencil">  |  </i></a>  
                @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                  <a class="pull-right" href="#" role="button" data-toggle="modal" data-target="#editAssetModal"><i class="fa fa-pencil">  |  </i></a>
                @endif                
                <a class="pull-right" href="/report/checklistsuite/{{ $asset->id }}"><i class="fa fa-print">  |  </i></a> 
            </h3> 
          </div>         
            <div class="panel-body">
              <div class="row"> <!-- Top Row -->
                <div class="col-md-6">
                  <h3><u>Asset:</u> {{ $asset->asset_tag }}</h3>
                  <ul>
                    <li><strong>Asset Number:</strong> {{ $asset->asset_number }}</li>
                    <li><strong>Asset Name:</strong> {{ $asset->asset_title }}</li>
                    <li><strong>Asset Type:</strong> {{ $asset->asset_type }}</li>
                    <li><strong>Asset Status:</strong> {{ $asset->asset_status }} %</li>
                  </ul>
                </div>
                <div class="col-md-6">
                <h4>Asset Notes</h4>
                  <p>
                    {{ $asset->asset_notes}}
                  </p>
                </div>
              </div> <!-- Top Row Ends -->
              <h3>Prefunctional Checklists</h3>
              <hr>
              <div class="row"> <!-- Bottom Row -->
                <div class="col-md-12">
                  <table id="checklisttable" class="display">
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
                <h3>Functional Performance Tests</h3>
                <hr>
                  @if( $asset->functionaltests )
                  <table class="table">
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
                   @else                 
                    <p>No functional tests setup for this asset. Add FPTs <a href="#">here</a></p>                  
                  @endif
                <hr>
                <p><a class="btn btn-success btn-sm pull-right" href="/asset" role="button"><i class="fa fa-times"></i> Close</a></p> 
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