@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - FPT: 
        <small>{{ $pagetitle }}</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="checklist">Asset</a></li>
        <li class="active">{{ $pagetitle }}</li>
      </ol>
@stop

@section('content')
        <!-- Application Dashboard -->
        <div class="row">
      
        <div class="col-md-12"> <!-- Main Panel Start -->
          <div class="box box-primary">
                 
            <div class="box-body">
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
</home>
@endsection