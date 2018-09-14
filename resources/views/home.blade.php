@extends('adminlte::page')

@section('title', 'CxMNGR - home')

@section('page_stylesheets')
    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection

@section('content_header')
<h1>
    Dashboard 
    <small>User Home</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
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
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a href="#assets" data-toggle="tab">Assets</a></li>
              <li><a href="#issues" data-toggle="tab">Issues</a></li>
              <li><a href="#templates" data-toggle="tab">Templates</a></li>
              <li class="active"><a href="#charts" data-toggle="tab">Charts</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="assets">
                <!-- Assets -->
                <div class="panel panel-primary">                 
                  <div class="panel-body">
                    <table id="table1" class="table table-striped">
                      <thead>                 
                      <tr>
                        <th>Tag</th>
                        <th>Asset Name</th>
                        <th>Type</th>
                        <th>%</th>
                      </tr>                 
                    </thead>
                      <tbody>
                        @foreach ( $assets as $asset )
                          <tr>
                            <td><a href="/asset/show/{{ $asset->id }}">{{ $asset->asset_tag }}</a></td>
                            <td><a href="/asset/show/{{ $asset->id }}">{{ $asset->asset_title }}</a></td>
                            <td>{{ $asset->asset_type }}</td>
                            <td><span class="badge bg-yellow">{{ $asset->asset_status }}%</span></td>
                          </tr>
                        @endforeach                     
                      </tbody>
                    </table>
                  </div>
                  <!-- /.panel-body -->
                </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="issues">
                <!-- The Issues -->
                <div class="panel panel-primary">                 
                  <div class="panel-body">
                    <table id="table2" class="table table-striped">
                      <thead>                  
                        <tr>
                          <th>#</th>
                          <th>Type</th>
                          <th>Title</th>
                          <th>Priority</th>
                          <th>Status</th>
                        </tr>                 
                      </thead>
                      <tbody>
                        @foreach ( $projissues as $issue )
                          <tr>
                            <td><a href="/issue/show/{{ $issue->id }}">{{ $issue->id }}</a></td>
                            <td>{{ $issue->issue_type }}</td>
                            <td><a href="/issue/show/{{ $issue->id }}">{{ $issue->issue_title }}</a></td>
                            <td><span class="badge bg-yellow">{{ $issue->issue_priority }}</span></td>
                            <td><span class="badge bg-info">{{ $issue->issue_status }}</span></td>
                          </tr>
                        @endforeach
                        </tbody>
                    </table>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="templates">
                <!-- The Templates -->
                <div class="panel panel-primary">                 
                  <div class="panel-body">
                    <table id="table3" class="table table-striped">
                      <thead>                  
                        <tr>
                          <th>Name</th>
                          <th>Type</th>
                          <th>Status</th>
                        </tr>                 
                      </thead>
                      <tbody>
                        @foreach ( $projtemplates as $projtemplate )
                          <tr>
                            <td><a href="/template/{{ $projtemplate->id }}">{{ $projtemplate->template_name }}</a></td>
                            <td>{{ $projtemplate->template_type }}</td>
                            <td><span class="badge bg-yellow">{{ $projtemplate->status }}</span></td>
                          </tr>
                        @endforeach
                        </tbody>
                    </table>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.tab-pane -->

              <div class="active tab-pane" id="charts">
                <h3>Charts</h3>
                <row>
                  <!-- DONUT CHART -->
                    <div class="box box-info">
                      <div class="box-header with-border">
                        <h3 class="box-title">Issues by Status</h3>

                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                      <div class="box-body">
                      <canvas id="unresolvedIssuesByDiscipline" height="150"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <div class="box box-info">
                      <div class="box-header with-border">
                        <h3 class="box-title">Checklist Remaining by Discipline</h3>

                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                      <div class="box-body">
                      <canvas id="checklistRemainingByDiscipline" height="150"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </row>

              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

<script>
var issrem = document.getElementById("unresolvedIssuesByDiscipline").getContext('2d');
var myChart = new Chart(issrem, {
    type: 'doughnut',
    data: {
        labels: ["Unresolved", "Resolved", "Closed", "Cancelled", "Pending"],
        datasets: [{
            label: 'Issues by Status',
            data: [{{ $issuesunres }}, {{ $issuesres }}, {{ $issuesclosed }}, {{ $issuescanceled }}, {{ $issuespending}}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
    }
});

var clrem = document.getElementById("checklistRemainingByDiscipline").getContext('2d');
var myChart = new Chart(clrem, {
    type: 'horizontalBar',
    data: {
        labels: ["Mechanical", "Electrical", "Plumbing", "Controls", "TAB"],
        datasets: [{
            label: 'Total Checklist',
            data: [ {{ $totclmech }}, {{ $totclelec }}, {{ $totclplumb }}, {{ $totclcontr }}, {{ $totcltab }}
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        },
        {
            label: 'Completed Checklist',
            data: [{{ $complclmech }}, {{ $complclelec }}, {{ $complclplumb }}, {{ $complclcontr }}, {{ $complcltab }}],
            backgroundColor: [
                'rgba(54, 162, 235, 0.2',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        },
        {
            label: 'Remaining Checklist',
            data: [{{ $remclmech }}, {{ $remclelec }}, {{ $remclplumb }}, {{ $remclcontr }}, {{ $remcltab }}],
            backgroundColor: [
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
    }
});
</script>
@stop

@section('footer')
	@include('adminlte::partials.footer')
@stop