@extends('spark::layouts.app')

@section('scripts')
    <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>
@endsection

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
        <div class="col-md-3">
          <div class="panel panel-success">
          <div class="panel-heading">
            <h3 class="panel-title">{{ $project->project_title }}</h3>
          </div>
            <div class="panel-body">
                <p><img src="/storage/upload/images/{{ $project->thumbnail }}" class="img-rounded" alt="Project Image" width="100%">
                </p>
                <p>
                  {{ $project->project_notes }}
                </p>
                  <ul>
                    <li><strong>Project #:</strong> {{ $project->project_number }}</li>
                    <li><strong>Title:</strong> {{ $project->project_title }}</li>
                    <li><strong>Start Date:</strong> {{ $project->project_start_date }}</li>
                    <li><strong>End Date</strong> {{ $project->project_end_date }}</li>
                    <li><strong>% Complete:</strong> {{ $project->project_percent_complete }}</li>
                    <li><strong>No. of Assets:</strong> <a href="/asset/{{ $project->id }}">{{ $assetscount }}</a></li>
                    <li><strong>No. of Checklist:</strong> <a href="/checklist/{{ $project->id }}">{{ $checklistscount }}</a></li>
                    <li><strong>No. of Issues:</strong> <a href="/issue/{{ $project->id }}">{{ $issuescount }}</a></li>
                  </ul> 
                <p>
                  <a class="btn btn-success btn-sm pull-right" href="/project/{{ $project->id }}/edit" role="button"><i class="fa fa-btn fa-pencil-square-o"></i></a>                 
                  <form action="{{ url('project/'.$project->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" id="delete-project-{{ $project->id }}" class="btn btn-sm btn-danger">
                    <i class="fa fa-btn fa-trash"></i> </button>
                  </form>
                </p>         
            </div>  
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Summaries</h3>
          </div>
            <div class="panel-body">

              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Issues -  <span class="badge">{{ $issuescount }}</span><span><a class="pull-right" href="/issue/{{ $project->id }}" role="button"> <i class="fa fa-sign-in" aria-hidden="true"></i> </a></span>
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                      <p><strong>Total Number of Issues:</strong> {{ $issuescount }}</p>
                      <p><strong>Number of Design Issues:</strong> {{ $designissuescount }}</p>
                      <p><strong>Number of Construction Issues:</strong> {{ $constructionissuescount }}</p>
                      <p><strong>Number of Submittal Issues:</strong> {{ $submittalissuescount }}</p>
                      <p><strong>Number of Testing Issues:</strong> {{ $testingissuescount }}</p>
                      <p><strong>Number of Checklist Issues:</strong> {{ $checklistissuescount }}</p>
                      <hr>
                      <p><strong>Number of Unresolved Issues:</strong> {{ $unresolvedissuescount }}</p>
                      <p><strong>Number of Resolved Issues:</strong> {{ $resolvedissuescount }}</p>
                      <hr>
                      <p><strong>High Priority Issues:</strong> {{ $highpriorityissuescount }}</p>
                      <p><strong>Medium Priority Issues:</strong> {{ $mediumpriorityissuescount }}</p>
                      <p><strong>Low Priority Issues:</strong> {{ $lowpriorityissuescount }}</p>
                      <hr>
                      <p><strong>Mechanical Issues:</strong> ..</p>
                      <p><strong>Electrical Issues:</strong> ..</p>
                      <p><strong>Plumbing Issues:</strong> ..</p>
                      <p><strong>TAB Issues:</strong> ..</p>
                      <p><strong>Controls Issues:</strong> ..</p>
                      <hr>
                      <p><a class="btn btn-success pull-right" href="/issue/{{ $project->id }}" role="button">Go to Issues &raquo;</a></p>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Assets -  <span class="badge">{{ $assetscount }}</span><span><a class="pull-right" href="/asset/{{ $project->id }}" role="button"> <i class="fa fa-sign-in" aria-hidden="true"></i> </a></span>
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      <p><strong>Total Number of Assets:</strong>  {{ $assetscount }}</p>
                      <p><strong>Number of Mechanical Assets:</strong> 100</p>
                      <p><strong>Number of Electrical Assets:</strong> 50</p>
                      <p><strong>Number of Plumbing Assets:</strong> 50</p>
                      <hr>
                      <p><strong>Total Completed Assets:</strong> 50 / 200 (25%)</p>
                      <p><strong>Mechanical Completed Assets:</strong> 25 / 100 (25%)</p>
                      <p><strong>Electrical Completed Assets:</strong> 10 / 50 (20%)</p>
                      <p><strong>Plumbing Completed Assets:</strong> 15 / 50 (30%)</p>
                      <hr>
                      <p><a class="btn btn-success pull-right" href="/asset/{{ $project->id }}" role="button">Go to Assets &raquo;</a></p>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Checklists -  <span class="badge">{{ $checklistscount }}</span><span><a class="pull-right" href="/checklist/{{ $project->id }}" role="button"> <i class="fa fa-sign-in" aria-hidden="true"></i> </a></span>
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                      <p><strong>Total Number of Checklists:</strong> 2500</p>
                      <p><strong>Number of Mechanical Checklists:</strong> 1500</p>
                      <p><strong>Number of Electrical Assets:</strong> 500</p>
                      <p><strong>Number of Plumbing Checklists:</strong> 500</p>
                      <hr>
                      <p><strong>Total Completed Checklists:</strong> 500 / 2500 (20%)</p>
                      <p><strong>Mechanical Completed Checklists:</strong> 300 / 1500 (20%)</p>
                      <p><strong>Electrical Completed Checklists:</strong> 250 / 500 (50%)</p>
                      <p><strong>Plumbing Completed Checklists:</strong> 200 / 500 (40%)</p>
                      <hr>
                      <p><a class="btn btn-success pull-right" href="issues.html" role="button">Go to Checklists &raquo;</a></p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!---------------->

          <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Cx Team</h3>
          </div>
            <div class="panel-body">
               <div class="row">

                          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                              <a class="thumbnail" href="#">
                                  <img class="img-responsive" :src="user.photo_url" alt="" style="height: 75px;">
                              </a>
                              <p><small>{{ $project->user->name }} - Cx Manager</small></p>
                          </div>
                          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                              <a class="thumbnail" href="#">
                                  <img class="img-responsive" src="http://placehold.it/400x300" alt="">
                              </a>
                              <p>Contractor Name - Contractor Role</p>
                          </div>
                          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                              <a class="thumbnail" href="#">
                                  <img class="img-responsive" src="http://placehold.it/400x300" alt="">
                              </a>
                              <p>Contractor Name - Contractor Role</p>
                          </div>
                          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                              <a class="thumbnail" href="#">
                                  <img class="img-responsive" src="http://placehold.it/400x300" alt="">
                              </a>
                              <p>Contractor Name - Contractor Role</p>
                          </div>
                          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                              <a class="thumbnail" href="#">
                                  <img class="img-responsive" src="http://placehold.it/400x300" alt="">
                              </a>
                              <p>Contractor Name - Contractor Role</p>
                          </div>
                          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                              <a class="thumbnail" href="#">
                                  <img class="img-responsive" src="http://placehold.it/400x300" alt="">
                              </a>
                              <p>Contractor Name - Contractor Role</p>
                          </div>
                          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                              <a class="thumbnail" href="#">
                                  <img class="img-responsive" src="http://placehold.it/400x300" alt="">
                              </a>
                              <p>Contractor Name - Contractor Role</p>
                          </div>
                          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                              <a class="thumbnail" href="#">
                                  <img class="img-responsive" src="http://placehold.it/400x300" alt="">
                              </a>
                              <p>Contractor Name - Contractor Role</p>
                          </div>           
              </div>
              <p><a class="btn btn-primary btn-sm pull-right" href="#" role="button">Manage Project Users &raquo;</a></p>
            </div>
          </div>
       </div>
        <div class="col-md-3">
        <div class="panel panel-success">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-info" aria-hidden="true"></i> Help</h3>
          </div>
          <div class="panel-body">
            <strong>Choose Task:</strong>
            <OL>
              <li>Click arrow next to task name to enter the task details</li>
              <center><strong>or</strong></center>
              <li>Click on the task name to get a summary. Then click "Go to ___" button at the bottom of the task summary to see the task's details</li>
            </OL>
          </div>
        </div>

        <div class="panel panel-success">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cog" aria-hidden="true"></i> Task Manager</h3>
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
                  <td><a href="#">OPR</a></td>
                  <td>100</td>
                </tr>
                <tr>
                  <td><a href="#">BoD</a></td>
                  <td>100</td>
                </tr>
                <tr>
                  <td><a href="#">Cx Plan</a></td>
                  <td>100</td>
                </tr>
                <tr>
                  <td><a href="#">Cx Spec</a></td>
                  <td>100</td>
                </tr>
                <tr>
                  <td><a href="#">Design Review - 1</a></td>
                  <td>100</td>
                </tr>
                <tr>
                  <td><a href="#">Design Review - 2</a></td>
                  <td>100</td>
                </tr>
                <tr>
                  <td><a href="#">Submittal Review</a></td>
                  <td>100</td>
                </tr>
                <tr>
                  <td><a href="#">Cx Meetings (12)</a></td>
                  <td>50</td>
                </tr>
                <tr>
                  <td><a href="#">Site Reviews</a></td>
                  <td>50</td>
                </tr>
                <tr>
                  <td><a href="#">Owner Training</a></td>
                  <td>50</td>
                </tr>
                <tr>
                  <td><a href="#">O & M Manuals</a></td>
                  <td>50</td>
                </tr>
                <tr>
                  <td><a href="#">Functional Testing</a></td>
                  <td>25</td>
                </tr>
                <tr>
                  <td><a href="#">Systems Manual</a></td>
                  <td>25</td>
                </tr>
                <tr>
                  <td><a href="#">Seasonal Testing</a></td>
                  <td>0</td>
                </tr>
                <tr>
                  <td><a href="#">Final Report</a></td>
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
      </div>
    </div>
</home>
@endsection