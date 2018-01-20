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
      </div>
      <!-- /.col -->
    </div>
    
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-6 invoice-col">
        <address>
          <strong>Basic Asset Info.</strong><br>
          <strong>Asset Number:</strong> {{ $asset->asset_number }}<br>
          <strong>Asset Name:</strong> {{ $asset->asset_title }}<br>
          <strong>Asset Type:</strong> {{ $asset->asset_type }}<br>
          <strong>Asset Status:</strong> {{ $asset->asset_status }} %
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-6 invoice-col">
        <address>
          <strong>Asset Notes</strong><br>
          {{ $asset->asset_notes}}
        </address>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    
    @foreach ($asset->checklists as $checklist)
    <!-- Table row -->
    <div class="row">
    @if ( $checklist->checklist_title == "Model Verification" )
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <caption style="text-align: center;"><h4>{{ $checklist->checklist_title }}</h4></caption>
          <thead>
          <tr>
            <th>#</th>
            <th>Question</th>
            <th>Design</th>
            <th>Approved</th>
            <th>Delivered</th>
            <th>Comment</th>
          </tr>
          </thead>
          <tbody>
            @foreach ( $checklist->questions as $question )
            <tr>
                <td>{{ $question->question_order }}</td>
                <td >{{ $question->question_text }}</td>
                <td >{{ $question->answer_design }}</td>
                <td >{{ $question->answer_submitted }}</td>
                <td >{{ $question->answer_installed }}</td> 
                <td >{{ $question->answer_comment }}</td>                        
            </tr>
            @endforeach        
          </tbody>
        </table>
      </div>
      <!-- /.col -->
      @else
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
        <caption style="text-align: center;"><h4>{{ $checklist->checklist_title }}</h4></caption>
          <thead>
          <tr>
            <th>#</th>
            <th>Question</th>
            <th>Yes</th>
            <th>Comment</th>
          </tr>
          </thead>
          <tbody>
          @foreach ( $checklist->questions as $question )
          <tr>
            <td>{{ $question->question_order}}</td>
            <td >{{ $question->question_text}}</td>
            <td >{{ $question->answer_accepted }}</td>
            <td >{{ $question->answer_comment }}</td>                      
          </tr>
        @endforeach        
          </tbody>
        </table>
      </div>
      <!-- /.col -->
      @endif
    </div>
    <!-- /.row -->
    @endforeach
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>