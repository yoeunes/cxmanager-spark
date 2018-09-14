@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Templates: 
        <small>{{ $pagetitle }}</small>       
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
                <li class="list-group-item">
                  <b>Project Status:</b> <a class="pull-right">{{ $project->project_percent_complete }}%</a>
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
          <div class="box box-primary">
            <div class="box-body">
          <form class="form-horizontal" method="POST" action="/template/{{ $template->id }}">
              {{ method_field('PATCH')}}
              {{ csrf_field() }}

              <div class="form-group">
                <label for="id" class="col-sm-2 control-label">Template ID:</label>
                <div class="col-sm-10">
                    <input type="number" name="id" class="form-control" id="id" value="{{ $template->id }}"></input>
                </div>
               </div>

               <div class="form-group">
                <label for="user_id" class="col-sm-2 control-label">User ID:</label>
                <div class="col-sm-10">
                    <input type="number" name="user_id" class="form-control" id="user_id" value="{{ $template->user_id }}"></input>
                </div>
               </div>

               <div class="form-group">
                <label for="project_id" class="col-sm-2 control-label">Project ID:</label>
                <div class="col-sm-10">
                    <input type="number" name="project_id" class="form-control" id="project_id" value="{{ $template->project_id }}"></input>
                </div>
               </div>

              <div class="form-group">
                <label for="template_name" class="col-sm-2 control-label">Template Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="template_name" class="form-control" id="template_name" value="{{ $template->template_name }}"></input>
                </div>
               </div>

               @if(Auth::user()->email == 'ngray@energymanagementconsulting.com')
                <div class="form-group">
                  <label for="template_type" class="col-sm-2 control-label">Template Type:</label>
                  <div class="col-sm-10">
                    <select class="field" name="template_type" id="template_type">
                      <option value="global" @if(old("template_type", $template->template_type) == 'global') selected @endif >global</option>
                      <option value="project" @if(old("template_type", $template->template_type) == 'project') selected @endif >project</option>
                      <option value="user" @if(old("template_type", $template->template_type) == 'user') selected @endif>user</option>
                    </select>
                  </div>
                 </div>
               @elseif(Auth::user()->ownsTeam(Auth::user()->currentTeam) || Auth::user()->roleOn(Auth::user()->currentTeam ))
                 <div class="form-group">
                  <label for="template_type" class="col-sm-2 control-label">Template Type:</label>
                  <div class="col-sm-10">
                    <select class="field" name="template_type" id="template_type">
                      <option value="project">project</option>
                      <option value="user">user</option>
                    </select>
                  </div>
                 </div>
                @endif

              <div class="form-group">
                <label for="status" class="col-sm-2 control-label">Status:</label>
                <div class="col-sm-10">
                    <select class="field" name="status" id="status">
                      <option value="active" @if(old("status", $template->status) == 'active') selected @endif >active</option>
                      <option value="inactive" @if(old("status", $template->status) == 'inactive') selected @endif >inactive</option>
                    </select>
                </div>
               </div> 
               
            <hr> 

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <a class="btn btn-danger btn-sm" href="/template">Close</a>
                    <button type="submit" class="btn btn-primary pull-right">Update Template</button>
                    </div>
                  </div>
            </form> 
        </div>
      </div>
    </div>
      </div>
@endsection

@section('footer')
  @include('adminlte::partials.footer')
@endsection