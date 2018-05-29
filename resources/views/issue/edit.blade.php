@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Issue: 
        <small>{{ $pagetitle }}</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="issue">Issues</a></li>
        <li class="active">{{ $pagetitle }}</li>
      </ol>
@stop

@section('content')
        <!-- Application Dashboard -->
        <div class="row">
          <!-- Left Menu -->

          <!-- Left Menu End -->

          <!-- Main Content (middle panel) -->
          <div class="col-md-12">            
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Edit Issue</h3> 
              </div>
              <div class="panel-body">
                 
                  <form class="form-horizontal" method="POST" action="/issue/{{ $issue->id }}">
                      {{ method_field('PATCH')}}
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label for="issue_title" class="col-sm-2 control-label">Issue Title</label>
                          <div class="col-sm-10">
                        <input type="text" name="issue_title" class="form-control" id="issue_title" value="{{ $issue->issue_title }}"></input>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="issue_type" class="col-sm-2 control-label">Issue Type</label>
                            <label class="radio-inline">
                              <input type="radio" name="issue_type" id="issue_type" value="Checklist" @if(old("issue_type", $issue->issue_type) == 'Checklist' )  checked='checked' @endif >Checklist
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="issue_type" id="issue_type" value="Design" @if(old("issue_type", $issue->issue_type) == 'Design' )  checked='checked' @endif  >Design
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="issue_type" id="issue_type" value="Construction" @if(old("issue_type", $issue->issue_type) == 'Construction' )  checked='checked' @endif  >Construction
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="issue_type" id="issue_type" value="Submittal" @if(old("issue_type", $issue->issue_type) == 'Submittal' )  checked='checked' @endif  >Submittal
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="issue_type" id="issue_type" value="Testing" @if(old("issue_type", $issue->issue_type) == 'Testing' )  checked='checked' @endif  >Testing
                            </label>
                      </div>

                      <div class="form-group">
                        <label for="issue_created_date" class="col-sm-2 control-label">Issue Date</label>
                        <div class="col-sm-10">
                        <input type="date" name="issue_created_date" id="issue_created_date" class="form-control" value="{{ $issue->issue_created_date }}"></input>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="issue_response_person" class="col-sm-2 control-label">Responsible Person</label>
                          <div class="col-sm-10">
                        <input type="text" name="issue_response_person" class="form-control" id="issue_response_person" value="{{ $issue->issue_response_person }}"></input>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="issue_response_date" class="col-sm-2 control-label">Response Deadline</label>
                        <div class="col-sm-10">
                        <input type="date" name="issue_response_date" id="issue_response_date" class="form-control" value="{{ $issue->issue_response_date }}"></input>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="issue_status" class="col-sm-2 control-label">Issue Status</label>
                        <label class="radio-inline">
                              <input type="radio" name="issue_status" id="issue_status" value="Open" @if(old("issue_status", $issue->issue_status) == 'Open' )  checked='checked' @endif  >Open
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="issue_status" id="issue_status" value="Pending" @if(old("issue_status", $issue->issue_status) == 'Pending' )  checked='checked' @endif  >Pending
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="issue_status" id="issue_status" value="Resolved" @if(old("issue_status", $issue->issue_status) == 'Resolved' )  checked='checked' @endif  >Resolved
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="issue_status" id="issue_status" value="Cancelled" @if(old("issue_status", $issue->issue_status) == 'Cancelled' )  checked='checked' @endif  >Cancelled
                            </label>
                      </div>

                      <div class="form-group">
                        <label for="issue_description" class="col-sm-2 control-label">Description</label>
                          <div class="col-sm-10">
                        <textarea name="issue_description" class="form-control" id="issue_description" rows="5">{{ $issue->issue_description }}</textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="issue_recommendation" class="col-sm-2 control-label">Recommendation</label>
                          <div class="col-sm-10">
                        <textarea name="issue_recommendation" class="form-control" id="issue_recommendation" rows="5">{{ $issue->issue_recommendation }}</textarea>
                        </div>
                      </div>

                      <div class="form-group">
                      <label for="issue_priority" class="col-sm-2 control-label">Issue Priority</label>
                      <label class="radio-inline">
                              <input type="radio" name="issue_priority" id="issue_priority" value="Critical" @if(old("issue_priority", $issue->issue_priority) == 'Critical' )  checked='checked' @endif  >Critical
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_priority" id="issue_priority" value="High" @if(old("issue_priority", $issue->issue_priority) == 'High' )  checked='checked' @endif  >High
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_priority" id="issue_priority" value="Medium" @if(old("issue_priority", $issue->issue_priority) == 'Medium' )  checked='checked' @endif  >Medium
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_priority" id="issue_priority" value="Low" @if(old("issue_priority", $issue->issue_priority) == 'Low' )  checked='checked' @endif  >Low
                          </label>
                      </div>

                      <div class="form-group">
                        <label for="issue_resolution" class="col-sm-2 control-label">Final Resolution</label>
                          <div class="col-sm-10">
                        <textarea name="issue_resolution" class="form-control" id="issue_resolution" rows="5">{{ $issue->issue_resolution }}</textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                        <a class="btn btn-danger btn-sm" href="/issue">Close</a>
                        <button type="submit" class="btn btn-primary pull-right">Update Issue</button>
                        </div>
                      </div>

                    </form>

              </div>
            </div>
         </div>
        <!-- Main Content (middle panel) End -->

      </div>
@endsection

@section('footer')
  @include('adminlte::partials.footer')
@endsection