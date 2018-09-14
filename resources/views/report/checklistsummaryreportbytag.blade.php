@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Reports: 
        <small>Checklist Summary Report</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="report">Reports</a></li>
        <li class="active">Summary Report</li>
      </ol>
@stop

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content">

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            Checklist Summary Report
            <small class="pull-right">{{ Carbon\Carbon::now()->toFormattedDateString() }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

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

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="/report/checklistsummaryreportprint" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('footer')
  @include('adminlte::partials.footer')
@endsection