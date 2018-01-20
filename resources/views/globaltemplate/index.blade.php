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
                <h3 class="panel-title">Available Global Templates
                  @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                    <a href="#" class="pull-right"><i class="fa fa-plus"></i></a>
                  @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                    <a href="#" class="pull-right"><i class="fa fa-plus"></i></a>
                  @endif
                </h3>
          </div>
          <div class="panel-body">          
                  <table id="assettable" class="display">
                    <thead>                 
                      <tr>
                        <th>ID</th>
                        <th>Template Name</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th></th>
                      </tr>                 
                    </thead>
                    <tbody>
                    @foreach ( $assettypes as $assettype )
                      <tr>
                        <td>{{ $assettype->id }}</td>
                        <td><a href="/globaltemplate/{{ $assettype->id }}">{{ $assettype->type_name }}</a></td>
                        <td>{{ $assettype->created_at }}</td>
                        <td>{{ $assettype->updated_at }}</td>                       
                          <td class="text"> 
                            <form action="{{ url('assettype/'.$assettype->id) }}" method="POST" class="form-inline">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}                     
                              <button type="submit" id="delete-assettype-{{ $assettype->id }}" class="btn btn-sm btn-link">
                              <i class="fa fa-btn fa-trash"></i></button>
                            </form>
                          </td>
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
