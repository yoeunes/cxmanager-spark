@extends('spark::layouts.app')

@section('scripts')
    <link href='https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
          $('#questiontable').DataTable();
      } );
    </script>
@endsection

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
      
        <div class="col-md-12"> <!-- Main Panel Start -->
          <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Functional Performance Test
                <a href="/home" class="pull-right"><i class="fa fa-home"></i> | </a>
                <a href="/functionaltest/{{ $asset->id }}/fill"  class="pull-right" role="button"><i class="fa fa-pencil"></i> | </a>
                <a href="#" class="pull-right"><i class="fa fa-print"></i> | </a>
            </h3> 
          </div>         
            <div class="panel-body">
              <div class="row"> <!-- Top Row -->
                <div class="col-md-8">
                  <h3><u>Test:</u> {{ $functionaltest->functionaltest_title }}</h3>
                  <ul style="list-style-type:circle">
                    <li><strong>Asset:</strong> {{ $asset->asset_tag }}</li>
                    <li><strong>Test Tag:</strong> {{ $functionaltest->functionaltest_tag }}</li>
                    <li><strong>Test Type:</strong> {{ $functionaltest->functionaltest_type }}</li>
                    <li><strong>Required Contrator:</strong> {{ $functionaltest->functionaltest_contractor }}</li>
                    <li><strong>Status:</strong> {{ $functionaltest->functionaltest_status }}</li>
                  </ul>

                </div>
                <div class="col-md-4">
                <h4>Test Notes</h4>
                  <p>
                    {{ $functionaltest->functionaltest_notes}}
                  </p>
                </div>               
              </div> <!-- Top Row Ends -->
              <hr>                 
              <div class="row"> <!-- Bottom Row -->
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Question</th>
                            <th>Expected Answer</th>
                            <th>Answer</th>
                            <th>Comment</th>
                            <th>Accepted</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                        @foreach( $functionaltest->functionaltestquestions as $fptquestion )
                            <tr>
                                <td>{{ $fptquestion->question_order }}</td>
                                <td>{{ $fptquestion->question_text }}</td>
                                <td>{{ $fptquestion->answer_design }}</td>
                                <td>{{ $fptquestion->answer_installed }}</td>
                                <td>{{ $fptquestion->answer_comment }}</td>
                                <td>{{ $fptquestion->answer_accepted }}</td>
                                <td>{{ $fptquestion->question_status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <p><a class="btn btn-success btn-sm pull-right" href="/asset/show/{{ $functionaltest->asset->id }}" role="button"><i class="fa fa-times"></i> Close</a></p> 
                </div>
              </div> <!-- Bottom Row Ends  -->                                        
            </div>
          </div>
        </div> <!-- Main Panel End -->
        </div>
      </div>
    </div>
</home>
@endsection