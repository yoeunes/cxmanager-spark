@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Checklist: 
        <small>{{ $pagetitle }}</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/template">Template</a></li>
        <li class="active">{{ $pagetitle }}</li>
      </ol>
@stop

@section('content')
    <div class="row">     
      <div class="col-md-12"> <!-- Main Panel Start -->
          <div class="panel panel-primary">
                 
            <div class="panel-body">
              <div class="row"> <!-- Top Row -->
                <div class="col-md-6">
                  <h3><u>Checklist Template:</u> {{ $checklisttemplate->checklist_title }}</h3>
                  <ul style="list-style-type:circle">
                    <li><strong>Template:</strong> {{ $checklisttemplate->template->template_name }}</li>
                    <li><strong>Checklist Name:</strong> {{ $checklisttemplate->checklist_title }}</li>
                    <li><strong>Checklist Type:</strong> {{ $checklisttemplate->checklist_type }}</li>
                    <li><strong>Checklist Contrator:</strong> {{ $checklisttemplate->checklist_contractor }}</li>
                    <li><strong>Status:</strong> {{ $checklisttemplate->checklist_status }}</li>
                  </ul>
                </div>
                <div class="col-md-6">
                <h4>Checklist Notes</h4>
                  <p>
                    {{ $checklisttemplate->checklist_notes}}
                  </p>
                </div>
              </div> <!-- Top Row Ends -->
              <hr>
              <div class="row"> <!-- Bottom Row -->
                <div class="col-md-12">

                      <table class="table table-striped">
                        <thead>
                          <th>#</th>
                          <th>Question</th>
                          @if(Auth::user()->email = 'ngray@energymanagementconsulting.com')
                            <th><a href="#" data-toggle="modal" data-target="#newQuestionModal"> <i class="fa fa-plus"></i></a></th>
                            <th><a href="#" data-toggle="modal" data-target="#editChecklistModal"> <i class="fa fa-pencil"></i></a></th>
                          @endif 
                        </thead>
                        <tbody>
                          @foreach (  $checklisttemplate->checklistquestiontemplate as $question )
                            <tr>
                              <td>{{ $question->question_order}}</td>
                              <td>{{ $question->question_text}}</td>
                              @if(Auth::user()->email = 'ngray@energymanagementconsulting.com')
                                <td><a href="/checklisttemplatequestion/editquestion/{{ $question->id }}"><i class="fa fa-pencil"></i></a></td>
                                <td> 
                                <form action="{{ url('checklisttemplatequestion/'.$question->id) }}" method="POST" class="form-inline">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}

                                  <button type="submit" id="delete-checklisttemplatequestion-{{ $question->id }}" class="btn btn-link">
                                  <i class="fa fa-btn fa-trash"></i></button>
                                </form>
                              </td>
                              @endif 
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    <p>
                     <a class="btn btn-info btn-sm pull-right" href="#" role="button" data-toggle="modal" data-target="#newQuestionModal"><i class="fa fa-plus"></i> Add Question</a>
                    <a class="btn btn-success btn-sm pull-right" href="/template/{{ $checklisttemplate->template->id }}" role="button"><i class="fa fa-times"></i> Close</a>
                    </p> 
                </div>  
              </div> <!-- Bottom Row Ends  -->                                        
            </div>
          </div>
        </div> <!-- Main Panel End -->
        </div>
      </div>

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
          <form class="form-horizontal" method="POST" action="/checklistquestiontemplate">
               {{ csrf_field() }}

               <input type="hidden" name="checklisttemplate_id" value="{{ $checklisttemplate->id }}"></input>

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
        <h4 class="modal-title">Edit Checklist Template</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/checklisttemplate/{{ $checklisttemplate->id }}">
               {{ method_field('PATCH')}}
               {{ csrf_field() }}

               <input type="hidden" name="team_id" value="{{ $checklisttemplate->team_id }}"> 

               <input type="hidden" name="asset_id" value="{{ $checklisttemplate->template_id }}"> 

               <input type="hidden" name="checklist_id" value="{{ $checklisttemplate->assettype_id }}"> 

                <div class="form-group">
                <label for="checklist_title" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_title" id="checklist_title" class="form-control" value="{{ $checklisttemplate->checklist_title }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="checklist_tag" class="col-sm-2 control-label">Tag</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_tag" id="checklist_tag" class="form-control" value="{{ $checklisttemplate->checklist_tag }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="checklist_contractor" class="col-sm-2 control-label">Contractor</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_contractor" id="checklist_contractor" class="form-control" value="{{ $checklisttemplate->checklist_contractor }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="checklist_status" class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_status" id="checklist_status" class="form-control" value="{{ $checklisttemplate->checklist_status }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="checklist_type" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_type" id="checklist_type" class="form-control" value="{{ $checklisttemplate->checklist_type }}"></input>
                </div>
                </div>

                <div class="form-group">
                <label for="checklist_category_order" class="col-sm-2 control-label">Order</label>
                <div class="col-sm-10">
                <input type="text" name="checklist_category_order" id="checklist_category_order" class="form-control" value="{{ $checklisttemplate->checklist_category_order }}"></input>
                </div>
                </div>

                <div class="form-group">
                  <label for="checklist_notes" class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                  <textarea name="checklist_notes" class="form-control" id="checklist_notes" rows="5">{{ $checklisttemplate->checklist_notes }}</textarea>
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

@section('footer')
  @include('adminlte::partials.footer')
@endsection

@section('page_scripts')
  <!-- page script -->
<script>
  $(function () {
    $('#checklisttable').DataTable({
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