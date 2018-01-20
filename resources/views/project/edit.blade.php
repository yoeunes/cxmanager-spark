@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
          <!-- Left Menu -->
          @include('shared.leftmenu')
          <!-- Left Menu End -->

          <!-- Main Content (middle panel) -->
           <div class="col-md-8">            
             <div class="panel panel-primary">
               <div class="panel-heading">
                 <h3 class="panel-title">Edit Project</h3> 
               </div>
               <div class="panel-body">
          
                   @include('spark::shared.errors')
                  
                   <form class="form-horizontal" method="POST" action="/project/{{ $project->id }}" enctype="multipart/form-data">
                    {{ method_field('PATCH')}}
                    {{ csrf_field() }}

                      <div class="form-group">
                        <label for="image" class="col-sm-2 control-label">Upload Image</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="file" name="image">
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="project_number" class="col-sm-2 control-label">Project #</label>
                        <div class="col-sm-10">
                          <input type="text" name="project_number" class="form-control" id="project_number" value="{{ $project->project_number }}" ></input>
                         </div>
                       </div>

                       <div class="form-group">
                        <label for="project_title" class="col-sm-2 control-label">Project Title</label>
                        <div class="col-sm-10">
                          <input type="text" name="project_title" class="form-control" id="project_title" value="{{ $project->project_title }}" ></input>
                         </div>
                       </div>

                       <div class="form-group">
                        <label for="project_name" class="col-sm-2 control-label">Project Name</label>
                        <div class="col-sm-10">
                          <input type="text" name="project_name" class="form-control" id="project_name" value="{{ $project->project_name }}" ></input>
                         </div>
                       </div>

                       <div class="form-group">
                       <label for="project_type" class="col-sm-2 control-label">Project Type</label>
                           <label class="radio-inline">
                               <input type="radio" name="project_type" id="project_type" value="New Commissioning" @if(old("project_type", $project->project_type) == 'New Commissioning' )  checked='checked' @endif >New Cx
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_type" id="project_type" value="Retro-Commissioning" @if(old("project_type", $project->project_type) == 'Retro-Commissioning' )  checked='checked' @endif >Retro-Cx
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_type" id="project_type" value="Energy Management" @if(old("project_type", $project->project_type) == 'Energy Management' )  checked='checked' @endif >Energy Mgmt.
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_type" id="project_type" value="Facility Assessment" @if(old("project_type", $project->project_type) == 'Facility Assessment' )  checked='checked' @endif >Fac. Assmt.
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_type" id="project_type" value="Asset Management" @if(old("project_type", $project->project_type) == 'Asset Management' )  checked='checked' @endif >Asset Mgmt.
                           </label>
                       </div>

                       <div class="form-group">
                       <label for="project_percent_complete" class="col-sm-2 control-label">% Complete</label>
                           <div class="col-sm-10">
                       <input type="text" name="project_percent_complete" class="form-control" id="project_percent_complete" value="{{ $project->project_percent_complete }}" ></input>
                       </div>
                       </div>

                       <div class="form-group">
                       <label for="project_status" class="col-sm-2 control-label">Status</label>
                       <label class="radio-inline">
                               <input type="radio" name="project_status" id="project_status" value="Not Started" @if(old("project_status", $project->project_status) == 'Not Started' )  checked='checked' @endif >Not Started
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_status" id="project_status" value="In Progress" @if(old("project_status", $project->project_status) == 'In Progress' )  checked='checked' @endif >In Progress
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_status" id="project_status" value="Completed" @if(old("project_status", $project->project_status) == 'Completed' )  checked='checked' @endif >Completed
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_status" id="project_status" value="Inactive" @if(old("project_status", $project->project_status) == 'Inactive' )  checked='checked' @endif >Inactive
                           </label>
                       </div>

                       <div class="form-group">
                       <label for="project_start_date" class="col-sm-2 control-label">Start Date</label>
                       <div class="col-sm-10">
                       <input type="date" name="project_start_date" id="project_start_date" class="form-control date" value="{{ $project->project_start_date }}"></input>
                       </div>
                       </div>

                       <div class="form-group">
                       <label for="project_end_date" class="col-sm-2 control-label">End Date</label>
                       <div class="col-sm-10">
                       <input type="date" name="project_end_date" id="project_end_date" class="form-control" value="{{ $project->project_end_date }}" ></input>
                       </div>
                       </div>

                       <div class="form-group">
                       <label for="project_construction_cost" class="col-sm-2 control-label">Construction Cost</label>
                       <div class="col-sm-10">
                       <input type="number" name="project_construction_cost" id="project_construction_cost" class="form-control" value="{{ $project->project_construction_cost }}"></input>
                       </div>
                       </div>

                       <div class="form-group">
                       <label for="project_cx_cost" class="col-sm-2 control-label">Cx Cost</label>
                       <div class="col-sm-10">
                       <input type="number" name="project_cx_cost" id="project_cx_cost" class="form-control" value="{{ $project->project_cx_cost }}"></input>
                       </div>
                       </div>

                       <div class="form-group">
                       <label for="project_notes" class="col-sm-2 control-label">Notes</label>
                           <div class="col-sm-10">
                       <textarea name="project_notes" class="form-control" id="project_notes" rows="5">{{ $project->project_notes}}</textarea>
                       </div>
                       </div>

                       <div class="form-group">
                       <div class="col-sm-offset-2 col-sm-10">
                       <a class="btn btn-danger btn-sm" href="/home">Close</a>
                       <button type="submit" class="btn btn-primary pull-right">Update Project</button>
                       </div>
                       </div>

                   </form>

               </div>
             </div>
          </div>
        <!-- Main Content (middle panel) End -->


        <!-- Right Info Panel -->

        <!-- Right Info Panel End -->


      </div>
    </div>
</home>
@endsection
