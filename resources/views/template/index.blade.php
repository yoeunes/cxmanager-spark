@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Templates: 
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
              <li class="active"><a href="#projtempl" data-toggle="tab">Project Templates</a></li>
              <li><a href="#usertempl" data-toggle="tab">User Templates</a></li>
              <li><a href="#globaltemp" data-toggle="tab">Global Templates</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="projtempl">
                <!-- Project Templates -->
                <div class="panel panel-primary">                 
                  <div class="panel-body">
                      <table id="table1" class="table table-striped">
                        <thead>                 
                        <tr>
                          <th>Template Name</th>
                          <th>Status</th>
                          <th>
                          @if(Auth::user()->ownsTeam(Auth::user()->currentTeam) || Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                            <a href="#" role="button" data-toggle="modal" data-target="#createBlankTemplateModal">  <i class="fa fa-plus"></i></a>
                          @endif
                          </th>
                        </tr>                 
                      </thead>
                        <tbody>
                          @foreach ( $projecttemplates as $projtempl )
                            <tr>
                              <td><a href="/template/{{ $projtempl->id }}">{{ $projtempl->template_name }}</a></td>
                              <td>{{ $projtempl->status }}</td>
                              <td></td>
                            </tr>
                          @endforeach                     
                        </tbody>
                      </table>
                  </div>
                  <!-- /.panel-body -->
                </div>
              </div>
              <!-- /.tab-pane -->             

              <div class="tab-pane" id="usertempl">                
                <!-- User Templates -->
                <div class="panel panel-primary">                 
                  <div class="panel-body">
                    <table id="table2" class="table table-striped">
                      <thead>                 
                      <tr>
                        <th>Template Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>                 
                    </thead>
                      <tbody>
                        @foreach ( $usertemplates as $utempl )
                          <tr>
                            <td><a href="#">{{ $utempl->template_name }}</a></td>
                            <td>{{ $utempl->status }}</td>
                            <td></td>
                          </tr>
                        @endforeach                     
                      </tbody>
                    </table>
                  </div>
                  <!-- /.panel-body -->
                </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="globaltemp">                
                <!-- Global Templates -->
                <div class="panel panel-primary">                 
                  <div class="panel-body">
                    <form  method="POST" action="/template/add">
                      {{ csrf_field() }}
                      <table id="table3" class="table table-striped">
                        <thead>                 
                        <tr>
                          <th>Template Name</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>                 
                      </thead>
                        <tbody>
                          @foreach ( $globaltemplates as $gtempl )
                            <tr>
                              <td><a href="template/{{ $gtempl->id }}">{{ $gtempl->template_name }}</a></td>
                              <td>{{ $gtempl->status }}</td>
                              <td>
                               <!-- checkbox -->
                                <div class="form-group">
                                  <label>
                                    <input name="gtempl-{{ $gtempl->id }}" type="checkbox" class="minimal">
                                  </label>
                                </div>
                              </td>
                            </tr>
                          @endforeach                     
                        </tbody>
                      </table>
                        <button type="submit" class="btn btn-primary">Add to Project</button>
                     </form>
                  </div>
                  <!-- /.panel-body -->
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
      </div>

<!-- Add Blank Template Modal -->
<div id="createBlankTemplateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Template</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/template/createblank">
               {{ csrf_field() }}

               <div class="form-group">
               <label for="template_name" class="col-sm-2 control-label">Template Title</label>
               <div class="col-sm-10">
               <input type="text" name="template_name" id="template_name" class="form-control" placeholder="Enter Name for Template" required></input>
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

@section('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/multiple-select/1.2.0/multiple-select.js"></script>
