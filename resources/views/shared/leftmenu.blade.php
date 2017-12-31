<div class="col-md-3">
  <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">{{ $project->project_title }}</h3>
      </div>
      <div class="panel-body">
          <p><img src="/storage/upload/images/{{ $project->thumbnail }}" class="img-rounded" alt="Project Image" width="100%"></p>
          <p>
            {{ $project->project_notes }}
          </p>
            <ul style="list-style-type:circle">
              <li><strong>Project #:</strong> {{ $project->project_number }}</li>
              <li><strong>Title:</strong> {{ $project->project_title }}</li>
              <li><strong>Start Date:</strong> {{ $project->project_start_date }}</li>
              <li><strong>End Date</strong> {{ $project->project_end_date }}</li>
              <li><strong>% Complete:</strong> {{ $project->project_percent_complete }}</li>
              <li><strong>No. of Assets:</strong> {{ $assetscount }}</li>
              <li><strong>No. of Checklist:</strong> {{ $checklistscount }}</li>
              <li><strong>No. of Issues:</strong> {{ $issuescount }}</li>
            </ul> 
          <p><a class="btn btn-success btn-sm pull-right" href="/home" role="button">Project Home &raquo;</a></p>         
      </div>  
  </div>
  
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Tasks</h3>
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
            <td><a href="/issue">Cx Issues</a></td>
            <td>100</td>
          </tr>
          <tr>
            <td><a href="/asset">Project Assets</a></td>
            <td>100</td>
          </tr>
          <tr>
            <td><a href="/asset">Construction Checklists</a></td>
            <td>100</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div> <!-- Left Panel End -->