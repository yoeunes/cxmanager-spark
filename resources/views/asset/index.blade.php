@extends('spark::layouts.app')

@section('scripts')
    <link href='https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
          $('#assettable').DataTable();
      } );
    </script>
@endsection

@section('content')
<home :user="user" inline-template>
  <div class="container">
    <!-- Application Dashboard -->
    <div class="row">
      <div class="col-md-9">
        <div class="panel panel-primary">
          <div class="panel-heading">
                <h3 class="panel-title">Assets
                  @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                    <a href="/asset/create" class="pull-right"><i class="fa fa-plus"></i></a>
                  @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                    <a href="/asset/create" class="pull-right"><i class="fa fa-plus"></i></a>
                  @endif
                </h3>
          </div>
          <div class="panel-body">          
                  <table id="assettable" class="display">
                    <thead>                 
                      <tr>
                        <th>Tag</th>
                        <th>Asset Name</th>
                        <th>Type</th>
                        <th>%</th>
                        @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                          <th></th>
                        @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                          <th></th>
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
                  <hr>
                  <p><a class="btn btn-success btn-sm pull-right" href="/home" role="button"><i class="fa fa-times"></i> Close</a></p> 
          </div>
        </div>
      </div>      
      @include('shared.leftmenu') 
    </div>      
  </div>
</home>
@endsection
