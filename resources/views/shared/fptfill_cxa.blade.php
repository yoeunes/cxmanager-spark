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

        <div class="col-md-12">
            <div class="panel panel-primary">
            <div class="panel-heading">
                    <h3 class="panel-title">Functional Tests
                    @if(Auth::user()->ownsTeam(Auth::user()->currentTeam))
                        <a href="/functionaltest/create" class="pull-right"><i class="fa fa-plus"></i></a>
                    @elseif(Auth::user()->roleOn(Auth::user()->currentTeam) == 'cxa')
                        <a href="/functionaltest/create" class="pull-right"><i class="fa fa-plus"></i></a>
                    @endif
                    </h3>
            </div>
            <div class="panel-body"> 
            <div class="row"> <!-- Top Row -->
            <div class="col-md-8">
              <h3><u>{{ $asset->asset_tag }}:</u> Functional Performance Testing</h3>
              <ul style="list-style-type:circle">
                <li><strong>Asset Type:</strong> {{ $asset->asset_type }}</li>
                <li><strong>Asset Tag:</strong> {{ $asset->asset_tag }}</li>
              </ul>

            </div>
            <div class="col-md-4">
            <h4>Asset Notes</h4>
              <p>
                {{ $asset->asset_notes}}
              </p>
            </div>               
          </div> <!-- Top Row Ends -->
                 
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach( $functionaltests as $fpt )
                <div class="panel panel-success">
                    <div class="panel-heading" role="tab" id="heading{{ $fpt->functionaltest_category_order }}">
                        <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $fpt->functionaltest_category_order }}" aria-expanded="false" aria-controls="collapse{{ $fpt->functionaltest_category_order }}">{{ $fpt->functionaltest_title }}</a> 
                         @if( $fpt->functionaltest_status == 100 ) <span class="pull-right"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                         @else <span class="pull-right"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span>   
                        @endif
                        </h4>
                    </div>
                    <div id="collapse{{ $fpt->functionaltest_category_order }}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{ $fpt->functionaltest_category_order }}">
                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="/functionaltest/{{ $fpt->id }}">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }} 
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Control Sequence</th>
                                <th>Question</th>
                                <th>Expected Answer</th>
                                <th>Actual Answer</th>
                                <th>Issue</th>
                                <th>Accepted</th>
                                <th>Status</th>
                            </thead>
                            <tbody>                             
                                @foreach( $fpt->functionaltestquestions as $q )
                                    <tr>
                                        <td>{{ $q->question_order }}</td>
                                        <td><input type="text" name="{{$q->id}}-control_sequence" class="form-control" placeholder="Sequence" value="{{ $q->control_sequence }}"></td>
                                        <td><textarea name="{{$q->id}}-question_text" id="{{$q->id}}-question_text" class="form-control" cols="30" rows="5">{{ $q->question_text }}</textarea></td>
                                        <td><input type="text" name="{{$q->id}}-answer_design" class="form-control" placeholder="Expected Answer" value="{{ $q->answer_design }}"></td>
                                        <td><input type="text" name="{{$q->id}}-answer_installed" class="form-control" placeholder="Actual Answer" value="{{ $q->answer_installed }}"></td>
                                        <td><input type="text" name="{{$q->id}}-answer_comment" class="form-control" placeholder="Comments" value="{{ $q->answer_comment }}"></td>
                                        <td><input type="checkbox" name="{{$q->id}}-answer_accepted" value="Yes" @if(old("{{$q->id}}-answer_accepted", $q->answer_accepted) == 'Yes' )  checked='checked' @endif ></td>
                                        <td>{{ $q->question_status }}</td>
                                    </tr>
                                @endforeach                            
                            </tbody> 
                        </table>
                        <button type="submit" class="btn btn-default pull-right">Submit</button>
                        </form> 
                        </div>
                    </div>
                </div>
                @endforeach
            </div> 
              <hr>
              <p><a class="btn btn-success btn-sm pull-right" href="/asset/show/{{ $asset->id }}" role="button"><i class="fa fa-times"></i> Close</a></p> 
      </div>
    </div>
  </div>
</div>      
</div>
</home>
@endsection
