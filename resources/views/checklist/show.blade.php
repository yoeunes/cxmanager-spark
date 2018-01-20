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
            <h3 class="panel-title">Checklist Profile
                <a href="/home" class="pull-right"><i class="fa fa-home"></i> | </a>
                <a href="#"  class="pull-right" role="button" data-toggle="modal" data-target="#editChecklistModal"><i class="fa fa-pencil"></i> | </a>
                <a href="/report/checklist/{{ $checklist->id }}" class="pull-right"><i class="fa fa-print"></i> | </a>
            </h3> 
          </div>         
            <div class="panel-body">
              <div class="row"> <!-- Top Row -->
                <div class="col-md-8">
                  <h3><u>Checklist:</u> {{ $checklist->checklist_tag }}</h3>
                  <ul style="list-style-type:circle">
                    <li><strong>Asset:</strong> {{ $checklist->asset->asset_tag }}</li>
                    <li><strong>Checklist Name:</strong> {{ $checklist->checklist_title }}</li>
                    <li><strong>Checklist Type:</strong> {{ $checklist->checklist_type }}</li>
                    <li><strong>Checklist Contrator:</strong> {{ $checklist->checklist_contractor }}</li>
                    <li><strong># of Comments:</strong> {{ $commentscount }}</li>
                    <li><strong>Status:</strong> {{ $checklist->checklist_status }}</li>
                  </ul>

                </div>
                <div class="col-md-4">
                <h4>checklist Notes</h4>
                  <p>
                    {{ $checklist->checklist_notes}}
                  </p>
                </div>               
              </div> <!-- Top Row Ends -->
              <hr>                 
              <div class="row"> <!-- Bottom Row -->
                <div class="col-md-12"> 
                      @if ( $checklist->checklist_title == "Model Verification" )
                        <table id="questiontable" class="display">
                          <thead>                   
                            <tr>
                              <th>#</th>
                              <th>Question</th>
                              <th>Design</th>
                              <th>Approved</th>
                              <th>Delivered</th>
                              <th>Comment</th>
                              <th></th>
                              <th><a href="#" role="button" data-toggle="modal" data-target="#newQuestionModal"><i class="fa fa-plus"></i></a></th>
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
                              <td><a href="/question/{{ $question->id }}/edit"><i class="fa fa-pencil"></i></a></td>
                              <td>
                                <form action="{{ url('question/'.$question->id) }}" method="POST" class="form-inline">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}

                                  <button type="submit" id="delete-question-{{ $checklist->id }}">
                                  <i class="fa fa-btn fa-trash"></i></button>
                                </form>
                              </td>                         
                            </tr>
                          @endforeach 
                          </form>
                          </tbody>
                      </table>
                @else
                    <table id="questiontable" class="display">
                      <thead>                   
                        <tr>
                          <th>#</th>
                          <th>Question</th>
                          <th>Yes</th>
                          <th>Comment</th>
                          <th></th>
                          <th><a href="#" role="button" data-toggle="modal" data-target="#newQuestionModal"><i class="fa fa-plus"></i></th>
                        </tr>                 
                      </thead>
                      <tbody>
                      <form action="{{ url('checklist/'.$checklist->id) }}" method="POST">
                              {{ csrf_field() }}
                      @foreach ( $checklist->questions as $question )
                        <tr>
                          <td>{{ $question->question_order}}</td>
                          <td >{{ $question->question_text}}</td>
                          <td >{{ $question->answer_accepted }}</td>
                          <td >{{ $question->answer_comment }}</td>
                          <td><a href="/question/{{ $question->id }}/edit"><i class="fa fa-pencil"></i></a></td>
                              <td>
                                <form action="{{ url('question/'.$question->id) }}" method="POST" class="form-inline">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}

                                  <button type="submit" id="delete-question-{{ $checklist->id }}">
                                  <i class="fa fa-btn fa-trash"></i></button>
                                </form>
                              </td>                       
                        </tr>
                      @endforeach                       
                      </tbody>
                      </form>
                  </table>
                  @endif               
                <hr>
                <p><a class="btn btn-success btn-sm pull-right" href="/asset/show/{{ $checklist->asset->id }}" role="button"><i class="fa fa-times"></i> Close</a></p> 
                </div>
              </div> <!-- Bottom Row Ends  -->                                        
            </div>
          </div>
        </div> <!-- Main Panel End -->
        </div>
      </div>
    </div>
</home>
<!-- Add Question Modal -->
<div id="newQuestionModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Question</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/question">
               {{ csrf_field() }}

               <input type="hidden" name="checklist_id" value="{{ $checklist->id }}"></input>

                <div class="form-group">
                  <label for="question_order" class="col-sm-2 control-label">#</label>
                  <div class="col-sm-10">
                    <input type="text" name="question_order" id="question_order" class="form-control" placeholder="enter position for question"></input>
                  </div>
                </div>

                <div class="form-group">
                <label for="question_text" class="col-sm-2 control-label">Question</label>
                <div class="col-sm-10">
                <input type="text" name="question_text" id="question_text" class="form-control" placeholder="enter new question"></input>
                </div>
                </div>

                <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary pull-right">Add</button>
                </div>
                </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal End -->

<!-- Edit Checklist Modal -->
<div id="editChecklistModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Checklist</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/checklist/{{ $checklist->id }}">
               {{ method_field('PATCH')}}
               {{ csrf_field() }}

               <input type="hidden" name="team_id" value="{{ $checklist->team_id }}"> 

               <input type="hidden" name="asset_id" value="{{ $checklist->asset_id }}"> 

               <input type="hidden" name="checklist_id" value="{{ $checklist->id }}"> 

                <div class="form-group">
                <label for="checklist_title" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_title" id="checklist_title" class="form-control" value="{{ $checklist->checklist_title }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="checklist_tag" class="col-sm-2 control-label">Tag</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_tag" id="checklist_tag" class="form-control" value="{{ $checklist->checklist_tag }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="checklist_contractor" class="col-sm-2 control-label">Contractor</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_contractor" id="checklist_contractor" class="form-control" value="{{ $checklist->checklist_contractor }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="checklist_status" class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_status" id="checklist_status" class="form-control" value="{{ $checklist->checklist_status }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="checklist_type" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_type" id="checklist_type" class="form-control" value="{{ $checklist->checklist_type }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="checklist_category_order" class="col-sm-2 control-label">Order</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_category_order" id="checklist_category_order" class="form-control" value="{{ $checklist->checklist_category_order }}"></input>
                </div>
                </div>

                <div class="form-group">
                  <label for="checklist_notes" class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                  <textarea name="checklist_notes" class="form-control" id="checklist_notes" rows="5">{{ $checklist->checklist_notes }}</textarea>
                  </div>
                </div>

                <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary pull-right">Update</button>
                </div>
                </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal End -->
@endsection