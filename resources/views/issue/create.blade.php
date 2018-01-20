@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <!-- left menu -->
            <!-- Left Menu End -->

          <!-- Main Content (middle panel) -->
          <div class="col-md-8">            
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">New Issue</h3> 
              </div>
              <div class="panel-body">
  
                  @include('spark::shared.errors')
                 
                  <form class="form-horizontal" method="POST" action="/issue">
                  {{ csrf_field() }}

                      <div class="form-group">
                      <label for="issue_title" class="col-sm-2 control-label">Issue Title</label>
                          <div class="col-sm-10">
                      <input type="text" name="issue_title" class="form-control" id="issue_title" placeholder="Issue Title" ></input>
                      </div>
                      </div>

                      <div class="form-group">
                      <label for="issue_type" class="col-sm-2 control-label">Issue Type</label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_type" id="issue_type" value="Checklist">Checklist
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_type" id="issue_type" value="Design">Design
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_type" id="issue_type" value="Construction">Construction
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_type" id="issue_type" value="Submittal">Submittal
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_type" id="issue_type" value="Testing">Testing
                          </label>
                      </div>

                      <div class="form-group">
                      <label for="issue_created_date" class="col-sm-2 control-label">Issue Date</label>
                      <div class="col-sm-10">
                      <input type="date" name="issue_created_date" id="issue_created_date" class="form-control date" ></input>
                      </div>
                      </div>

                      <div class="form-group">
                      <label for="issue_response_person" class="col-sm-2 control-label">Responsible</label>
                          <div class="col-sm-10">
                      <input type="text" name="issue_response_person" class="form-control" id="issue_response_person" placeholder="Who should respond" ></input>
                      </div>
                      </div>

                      <div class="form-group">
                      <label for="issue_response_date" class="col-sm-2 control-label">Deadline</label>
                      <div class="col-sm-10">
                      <input type="date" name="issue_response_date" id="issue_response_date" class="form-control" ></input>
                      </div>
                      </div>

                      <div class="form-group">
                      <label for="issue_status" class="col-sm-2 control-label">Issue Status</label>
                      <label class="radio-inline">
                              <input type="radio" name="issue_status" id="issue_status" value="Open">Open
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_status" id="issue_status" value="Pending">Pending
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_status" id="issue_status" value="Resolved">Resolved
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_status" id="issue_status" value="Cancelled">Cancelled
                          </label>
                      </div>

                      <div class="form-group">
                      <label for="issue_description" class="col-sm-2 control-label">Description</label>
                          <div class="col-sm-10">
                      <textarea name="issue_description" class="form-control" id="issue_description" placeholder="Describe the issue" ></textarea>
                      </div>
                      </div>

                      <div class="form-group">
                      <label for="issue_recommendation" class="col-sm-2 control-label">Recommendation</label>
                          <div class="col-sm-10">
                      <textarea name="issue_recommendation" class="form-control" id="issue_recommendation" placeholder="What do you recommend?" ></textarea>
                      </div>
                      </div>

                      <div class="form-group">
                      <label for="issue_priority" class="col-sm-2 control-label">Issue Priority</label>
                      <label class="radio-inline">
                              <input type="radio" name="issue_priority" id="issue_priority" value="Critical">Critical
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_priority" id="issue_priority" value="High">High
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_priority" id="issue_priority" value="Medium">Medium
                          </label>
                          <label class="radio-inline">
                              <input type="radio" name="issue_priority" id="issue_priority" value="Low">Low
                          </label>
                      </div>


                      <div class="form-group">
                      <label for="issue_resolution" class="col-sm-2 control-label">Final Resolution</label>
                          <div class="col-sm-10">
                      <textarea name="issue_resolution" class="form-control" id="issue_resolution" placeholder="How was the issue resolved?"></textarea>
                      </div>
                      </div>

                      <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                      <a class="btn btn-danger btn-sm" href="/issue">Cancel</a>
                      <button type="submit" class="btn btn-primary pull-right">Add Issue</button>
                      </div>
                      </div>

                  </form>

              </div>
            </div>
         </div>
        <!-- Main Content (middle panel) End -->


        <!-- Right Info Panel -->
        @include('shared.leftmenu')
        <!-- Right Info Panel End -->

      </div>
    </div>
</home>
@endsection