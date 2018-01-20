@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
          <!-- Left Menu -->
        <div class="col-md-4">
          <div class="panel panel-success">
          <div class="panel-heading">
            <h3 class="panel-title">Task Manager</h3>
          </div>
            <div class="panel-body">
            <table class="table table-hover table-condensed">
              <thead>
                
                <tr>
                  <th>Task</th>
                  <th>%</th>
                </tr>
                
              </thead>
              <tbody>
                <tr>
                  <td>OPR</td>
                  <td>100</td>
                </tr>
                <tr>
                  <td>BoD</td>
                  <td>100</td>
                </tr>
                <tr>
                  <td>Cx Plan</td>
                  <td>100</td>
                </tr>
                <tr>
                  <td>Cx Spec</td>
                  <td>100</td>
                </tr>
                <tr>
                  <td>Design Review - 1</td>
                  <td>100</td>
                </tr>
                <tr>
                  <td>Design Review - 2</td>
                  <td>100</td>
                </tr>
                <tr>
                  <td><a href="/issue">Cx Issues</a></td>
                  <td>100</td>
                </tr>
                <tr>
                  <td>Submittal Review</td>
                  <td>100</td>
                </tr>
                <tr>
                  <td><a href="/asset">Construction Checklists</a></td>
                  <td>100</td>
                </tr>
                <tr>
                  <td>Cx Meetings (12)</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Site Reviews</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Owner Training</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>O & M Manuals</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Functional Testing</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Systems Manual</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Seasonal Testing</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Final Report</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td></td>
                  <td>63.3</td>
                </tr>
              </tbody>
            </table>
            <p><a class="btn btn-success btn-sm pull-right" href="#" role="button">Manage Tasks &raquo;</a></p>            
            </div>  
          </div>
        </div>
          <!-- Left Menu End -->

          <!-- Main Content (middle panel) -->
           <div class="col-md-8">            
             <div class="panel panel-primary">
               <div class="panel-heading">
                 <h3 class="panel-title">New Project</h3> 
               </div>
               <div class="panel-body">
          
                   @include('spark::shared.errors')
                  
                   <form class="form-horizontal" method="POST" action="/project" enctype="multipart/form-data">
                   {{ csrf_field() }}

                  <input type="hidden" name="team_id" value="{{ Auth::user()->currentTeam->id }}"> 

                      <div class="form-group">
                        <label for="image" class="col-sm-2 control-label">Upload Image</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="file" name="image">
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="project_number" class="col-sm-2 control-label">Project #</label>
                        <div class="col-sm-10">
                          <input type="text" name="project_number" class="form-control" id="project_number" placeholder="Project Number" ></input>
                         </div>
                       </div>

                       <div class="form-group">
                        <label for="project_title" class="col-sm-2 control-label">Project Title</label>
                        <div class="col-sm-10">
                          <input type="text" name="project_title" class="form-control" id="project_title" placeholder="Project Short Name" ></input>
                         </div>
                       </div>

                       <div class="form-group">
                        <label for="project_name" class="col-sm-2 control-label">Project Name</label>
                        <div class="col-sm-10">
                          <input type="text" name="project_name" class="form-control" id="project_name" placeholder="Project Full Name" ></input>
                         </div>
                       </div>

                       <div class="form-group">
                       <label for="project_type" class="col-sm-2 control-label">Project Type</label>
                           <label class="radio-inline">
                               <input type="radio" name="project_type" id="project_type" value="New Commissioning">New Cx
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_type" id="project_type" value="Retro-Commissioning">R-Cx
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_type" id="project_type" value="Energy Management">Energy Mgmt.
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_type" id="project_type" value="Facility Assessment">Fac. Assmt.
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_type" id="project_type" value="Asset Management">Asset Mgmt.
                           </label>
                       </div>

                       <div class="form-group">
                       <label for="project_percent_complete" class="col-sm-2 control-label">% Complete</label>
                           <div class="col-sm-10">
                       <input type="text" name="project_percent_complete" class="form-control" id="project_percent_complete" placeholder="% Complete" ></input>
                       </div>
                       </div>

                       <div class="form-group">
                       <label for="project_status" class="col-sm-2 control-label">Status</label>
                       <label class="radio-inline">
                               <input type="radio" name="project_status" id="project_status" value="Not Started">Not Started
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_status" id="project_status" value="In Progress">In Progress
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_status" id="project_status" value="Completed">Completed
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="project_status" id="project_status" value="Inactive">Inactive
                           </label>
                       </div>

                       <div class="form-group">
                       <label for="project_start_date" class="col-sm-2 control-label">Start Date</label>
                       <div class="col-sm-10">
                       <input type="date" name="project_start_date" id="project_start_date" class="form-control date" ></input>
                       </div>
                       </div>

                       <div class="form-group">
                       <label for="project_end_date" class="col-sm-2 control-label">End Date</label>
                       <div class="col-sm-10">
                       <input type="date" name="project_end_date" id="project_end_date" class="form-control" ></input>
                       </div>
                       </div>

                       <div class="form-group">
                       <label for="project_construction_cost" class="col-sm-2 control-label">Construction Cost</label>
                       <div class="col-sm-10">
                       <input type="number" name="project_construction_cost" id="project_construction_cost" class="form-control" ></input>
                       </div>
                       </div>

                       <div class="form-group">
                       <label for="project_cx_cost" class="col-sm-2 control-label">Cx Cost</label>
                       <div class="col-sm-10">
                       <input type="number" name="project_cx_cost" id="project_cx_cost" class="form-control" ></input>
                       </div>
                       </div>

                       <div class="form-group">
                       <label for="project_notes" class="col-sm-2 control-label">Notes</label>
                           <div class="col-sm-10">
                       <textarea name="project_notes" class="form-control" id="project_notes" placeholder="Describe the project" ></textarea>
                       </div>
                       </div>

                       <div class="form-group">
                       <div class="col-sm-offset-2 col-sm-10">
                       <a class="btn btn-danger btn-sm" href="/home">Cancel</a>
                       <button type="submit" class="btn btn-primary pull-right">Create Project</button>
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
