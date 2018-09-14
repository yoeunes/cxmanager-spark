@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Assets: 
        <small>{{ $pagetitle }}</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/asset">Assets</a></li>
        <li class="active">{{ $pagetitle }}</li>
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
                <li class="list-group-item">
                  <b>Project Status:</b> <a class="pull-right">{{ $project->project_percent_complete }}%</a>
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
        <div class="col-md-9">
          <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="assettable" class="table table-hover">
                <thead>                 
                      <tr>
                        <th>Tag</th>
                        <th>Asset Name</th>
                        <th>Type</th>
                        <th>%</th>
                        @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                          <th><a href="asset/create" role="button"><i class="fa fa-plus"></i></a></th>
                        @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                          <th><a href="asset/create" role="button"><i class="fa fa-plus"></i></a></th>
                        @endif
                      </tr>                 
                    </thead>
                    <tbody>
                    @foreach ( $assets as $asset )
                      <tr>
                        <td>{{ $asset->asset_tag }}</td>
                        <td><a href="/asset/show/{{ $asset->id }}">{{ $asset->asset_title }}</a></td>
                        <td>{{ $asset->asset_type }}</td>
                        <td>{{ $asset->asset_status }} %</td>
                        @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                          <td class="text"> 
                            <form action="{{ url('asset/'.$asset->id) }}" method="POST" class="form-inline">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}                     
                              <button type="submit" id="delete-asset-{{ $asset->id }}" class="btn btn-sm btn-link">
                              <i class="fa fa-btn fa-trash"></i></button>
                            </form>
                          </td>
                          @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                            <td class="text"> 
                              <form action="{{ url('asset/'.$asset->id) }}" method="POST" class="form-inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}                     
                                <button type="submit" id="delete-asset-{{ $asset->id }}" class="btn btn-sm btn-link">
                                <i class="fa fa-btn fa-trash"></i></button>
                              </form>
                            </td>
                        @endif
                      </tr>
                    @endforeach 
                    </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('footer')
  @include('adminlte::partials.footer')
@endsection

@section('page_scripts')
<script>
  $(function () {
    $('#assettable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>
@endsection
