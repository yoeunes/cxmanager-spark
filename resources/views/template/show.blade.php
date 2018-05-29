@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - {{ $template->template_type }} template: 
        <small>{{ $template->template_name }}</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/template">Templates</a></li>
        <li class="active">{{ $pagetitle }}</li>
      </ol>
@stop

@section('content')
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="img-responsive img-square" src="{{ Auth::user()->currentTeam->photo_url }}" alt="User profile picture">

              <h3 class="profile-username text-center">{{ $project->project_title }}</h3>

              <!-- <p class="text-muted text-center">Software Engineer</p> -->

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b># of Issues</b> <a class="pull-right">{{ $issuescount }}</a>
                </li>
                <li class="list-group-item">
                  <b># of Assets</b> <a class="pull-right">{{ $assetscount }}</a>
                </li>
                <li class="list-group-item">
                  <b># of Checklists</b> <a class="pull-right">{{ $checklistscount }}</a>
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
              <h3 class="box-title">About this Project</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <p class="text-muted">
                {{ $project->project_notes }}
              </p>            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#templcl" data-toggle="tab">Template Checklists</a></li>
              <li><a href="#templfpt" data-toggle="tab">Templates FPTs</a></li>
              <li><a href="#templstats" data-toggle="tab">Template Statistics</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="templcl">
                <!-- Checklist Templates -->
                <div class="panel panel-primary">                 
                  <div class="panel-body">
                    <!-- Checklists -->
                      <table id="table1" class="table table-striped">
                        <thead>                   
                          <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Contractor</th>
                            <th>Type</th>
                            @if(Auth::user()->ownsTeam(Auth::user()->currentTeam) && $template->template_type == 'project')
                              <th></th>
                              <th><a href="#" role="button" data-toggle="modal" data-target="#addBlankChecklistTemplateModal">  <i class="fa fa-plus"></i></a></th>
                            @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa' && $template->template_type == 'project')
                              <th></th>
                              <th><a href="#" role="button" data-toggle="modal" data-target="#addBlankChecklistTemplateModal">  <i class="fa fa-plus"></i></a></th>
                            @endif 
                            
                          </tr>                 
                        </thead>
                        <tbody>
                        @foreach ( $template->checklisttemplate as $checklist )
                          <tr>
                            <td>{{ $checklist->checklist_category_order}}</td>
                            <td class="text"><a href="/checklisttemplate/{{ $checklist->id }}">{{ $checklist->checklist_title }}</a></td>
                            <td class="text">{{ $checklist->checklist_contractor }}</td>
                            <td class="text">{{ $checklist->checklist_type }}</td>
                            @if(Auth::user()->ownsTeam(Auth::user()->currentTeam) && $template->template_type == 'project')
                              <td><a href="#" role="button" ><i class="fa fa-pencil"></i> </a></td>
                              <td> 
                                <form action="{{ url('checklisttemplate/'.$checklist->id) }}" method="POST" class="form-inline">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}

                                  <button type="submit" id="delete-checklisttemplate-{{ $checklist->id }}" class="btn btn-link">
                                  <i class="fa fa-btn fa-trash"></i></button>
                                </form>
                              </td>
                            @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa' && $template->template_type == 'project')
                              <td><a href="#" role="button" ><i class="fa fa-pencil"></i> </a></td>
                              <td> 
                                <form action="{{ url('checklisttemplate/'.$checklist->id) }}" method="POST" class="form-inline">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}

                                  <button type="submit" id="delete-checklisttemplate-{{ $checklist->id }}" class="btn btn-link">
                                  <i class="fa fa-btn fa-trash"></i></button>
                                </form>
                              </td>
                            @endif                        
                          </tr>
                        @endforeach 
                        </tbody>
                      </table>
                  </div>
                  <!-- /.panel-body -->
                </div>
              </div>
              <!-- /.tab-pane -->             

              <div class="tab-pane" id="templfpt">                
                <!-- User Templates -->
                <div class="panel panel-primary">                 
                  <div class="panel-body">
                    <table id="table2" class="table table-striped">
                      <thead>
                      <th>#</th>
                      <th>Functional Test</th>
                      <th>Type</th>
                      @if(Auth::user()->ownsTeam(Auth::user()->currentTeam) && $template->template_type == 'project')
                        <th><a href="#">  <i class="fa fa-check-square-o"></i></a></th>
                        <th><a href="#">  <i class="fa fa-plus"></i></a></th>
                      @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa' && $template->template_type == 'project')
                        <th><a href="#">  <i class="fa fa-check-square-o"></i></a></th>
                        <th><a href="#">  <i class="fa fa-plus"></i></a></th>
                      @endif 
                    </thead>
                    <tbody>
                      @foreach( $template->fpttemplate as $fpt )
                        <tr>
                          <td>{{ $fpt->functionaltest_category_order }}</td>
                          <td><a href="#">{{ $fpt->functionaltest_title }}</a></td>
                          <td>{{ $fpt->functionaltest_type }}</td>
                          @if(Auth::user()->ownsTeam(Auth::user()->currentTeam) && $template->template_type == 'project')
                          <td><a href="#"><i class="fa fa-pencil"></i> </a></td>
                          <td> 
                            <form action="{{ url('fpt/'.$fpt->id) }}" method="POST" class="form-inline">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}

                                <button type="submit" id="delete-fpt-{{ $fpt->id }}" class="btn btn-link">
                                <i class="fa fa-btn fa-trash"></i></button>
                              </form>
                          </td>
                            @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa' && $template->template_type == 'project')
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
                  <!-- /.panel-body -->
                </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="templstats">                
                <!-- Global Templates -->
                <div class="panel panel-primary">                 
                  <div class="panel-body">
                    
                  </div>
                  <!-- /.panel-body -->
                </div>
              </div>
              <!-- /.tab-pane -->
              @if($template->template_type == 'global' || $template->template_type == 'user')
                <form  method="POST" action="/template/add">
                {{ csrf_field() }}
                  <input type="checkbox" name="gtempl-{{ $template->id }}" checked="checked" style="opacity:0; position:absolute; left:9999px;">
                  <button type="submit" class="btn btn-primary">Add to Project</button>
                </form>
              @endif
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
          
        </div>
      </div>

<!-- Add Checklist Template to Template Modal -->
<div id="addBlankChecklistTemplateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Checklist Template</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/checklisttemplate/{{ $template->id }}/createblank">
               {{ csrf_field() }} 

               <input type="hidden" name="template_id" value="{{ $template->id }}">

               <div class="form-group">
               <label for="checklist_title" class="col-sm-2 control-label">Title</label>
               <div class="col-sm-10">
               <input type="text" name="checklist_title" id="checklist_title" class="form-control" placeholder="Enter Title for checklist" required></input>
               </div>
               </div>

               <div class="form-group">
               <label for="checklist_contractor" class="col-sm-2 control-label">Contractor</label>
               <div class="col-sm-10">
               <input type="text" name="checklist_contractor" id="checklist_contractor" class="form-control" placeholder="eg. Mechanical Contractor" required></input>
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
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary pull-right">Add</button>
               </div>
               </div>
         </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!-- Modal End -->      
@endsection

@section('footer')
  @include('adminlte::partials.footer')
@endsection
