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
                <form class="form-horizontal" method="POST" action="/checklisttemplate/{{ $checklisttemplate->id }}">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <input type="hidden" name="checklisttemplateid" value="{{ $checklisttemplate->id }}"> 

                    @if ( $checklisttemplate->checklist_title == "Model Verification" )
                    <table id="checklisttable" class="table">
                        <thead><tr>
                            <th>Question</th>
                            <th>Design</th>
                            <th>Submittal</th>
                            <th>Delivered <a href="#" role="button" data-toggle="modal" data-target="#newQuestionModal"><i class="fa fa-plus pull-right"></i></a></th>
                            </tr>
                        </thead> 
                        <tbody>     
                            @foreach (  $checklisttemplate->checklistquestiontemplate as $question )
                            <input type="hidden" name="questionid-{{ $question->id }}" value="{{ $question->id }}"> 
                            <tr tr class="accordion-toggle info" data-toggle="collapse" data-target="#collapse{{ $question->id }}" >
                                <td>{{ $question->question_order}}. {{ $question->question_text}}</td>                         
                                <td><input type="text" name="{{$question->id}}-answer_design" class="form-control" placeholder="Design" value="{{ $question->answer_design }}"></td>
                                <td><input type="text" name="{{$question->id}}-answer_submitted" class="form-control" placeholder="Submittal" value="{{ $question->answer_submitted }}"></td>
                                <td><input type="text" name="{{$question->id}}-answer_installed" class="form-control" placeholder="Delivered" value="{{ $question->answer_installed }}"></td>                     
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3">
                                    <div id="collapse{{ $question->id }}" @if( $question->answer_comment ) class="collapse in" @else class="collapse" @endif >
                                    <input type="text" name="{{$question->id}}-answer_comment" class="form-control" placeholder="Comments" value="{{ $question->answer_comment }}">
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody> 
                    </table>
                    @else
                    <ul class="list-group">
                        @foreach (  $checklisttemplate->checklistquestiontemplate as $question )
                        <li class="list-group-item">{{ $question->question_order}}. {{ $question->question_text}}
                        <div class="input-group">
                            <span class="input-group-addon">
                                    <input type="checkbox" name="{{$question->id}}-answer_accepted" value="Yes" @if(old("{{$question->id}}-answer_accepted", $question->answer_accepted) == 'Yes' )  checked='checked' @endif >
                            </span>
                            <input type="text" name="{{$question->id}}-answer_comment" class="form-control" placeholder="Comments" value="{{ $question->answer_comment }}">
                        </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                    <p>
                    <button type="submit" class="btn btn-default">Submit</button>
                     <a class="btn btn-info btn-sm pull-right" href="#" role="button" data-toggle="modal" data-target="#newQuestionModal"><i class="fa fa-plus"></i> Add Question</a>
                    <a class="btn btn-success btn-sm pull-right" href="/template/{{ $checklisttemplate->template->id }}" role="button"><i class="fa fa-times"></i> Close</a>
                    </p> 
                        
                {{ Form::close() }}
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