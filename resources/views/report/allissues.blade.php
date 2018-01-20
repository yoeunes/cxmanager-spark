<!DOCTYPE html>
<html>
<head>
     <!-- Meta Information -->
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
 
     <title>@yield('title', config('app.name'))</title>
 
     <!-- Fonts -->
     <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
     <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
 
     <!-- CSS -->
     <link href="/css/app.css" rel="stylesheet">
 
     <!-- Scripts -->
     @yield('scripts', '')
 
     <!-- Global Spark Object -->
     <script>
         window.Spark = <?php echo json_encode(array_merge(
             Spark::scriptVariables(), []
         )); ?>;
     </script>
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
        <img src="/img/CxManager_logo_big.png" style="height: 32px;">
          <small class="pull-right">Date: {{ date('m-d-Y') }}</small>
        </h2>
        <h3>{{ $project->project_title }}</h3>
        <h4>Issues Log: {{ $pagetitle }}</h4>
      </div>
      <!-- /.col -->
    </div>

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>Type</th>
            <th>Title</th>
            <th>Found</th>
            <th>Respond By</th>
            <th>Responsible</th>
            <th>Priority</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
            @foreach ( $allissues as $issue )
            <tr>
                <td >{{ $issue->id }}</td>
                <td >{{ $issue->issue_type }}</td>
                <td >{{ $issue->issue_title }}</td>
                <td >{{ $issue->issue_created_date }}</td>
                <td >{{ $issue->issue_response_date }}</td> 
                <td >{{ $issue->issue_response_person }}</td>
                <td >{{ $issue->issue_priority }}</td>
                <td >{{ $issue->issue_status }}</td>                          
            </tr>
            @endforeach        
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>