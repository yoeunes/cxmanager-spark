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
     <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
 
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
        <h4><strong>Project Status:</strong> {{ $project->project_title }}</h4>
        <strong>Project Status - Checklist:</strong> {{ $project->project_percent_complete }}%
      </div>
      <!-- /.col -->
    </div>    
    
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Asset Type</th>
              <th># of Assets</th>
              <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($query as $asset)
                <tr>
                    <td>{{ $asset['asset_type'] }}</td>
                    <td>{{ $asset['asset_count']}}</td>
                    <td>{{ $asset['asset_status'] }} %</td>                       
                </tr>
            @endforeach 
            <tr>
              <td><strong>Total</strong></td>
              <td><strong>{{ $totalassetscount }}</strong></td>
              <td><strong>{{ $totalassetsstatus}} %</strong></td>
            </tr>  
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->
    
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>