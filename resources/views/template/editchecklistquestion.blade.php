@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        Checklist Template: 
        <small>Edit Question</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="checklisttemplate/{ $question->checklisttemplate_id }">Template</a></li>
        <li class="active">Edit Checklist Question</li>
      </ol>
@stop

@section('content')
    <!-- Application Dashboard -->
    <div class="col-md-12"> <!-- Main Panel Start -->
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Edit Question
          </h3> 
        </div>

        <div class="panel-body">
           <form class="form-horizontal" method="POST" action="/checklisttemplatequestion/{{ $question->id }}">
              {{ method_field('PATCH')}}
              {{ csrf_field() }}

              <div class="form-group">
                <label for="question_order" class="col-sm-2 control-label">Order:</label>
                <div class="col-sm-10">
                    <input type="number" name="question_order" class="form-control" id="question_order" value="{{ $question->question_order }}"></input>
                </div>
               </div>

              <div class="form-group">
                <label for="question_text" class="col-sm-2 control-label">Question:</label>
                <div class="col-sm-10">
                    <input type="text" name="question_text" class="form-control" id="question_text" value="{{ $question->question_text }}"></input>
                </div>
               </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <a class="btn btn-danger btn-sm" href="/checklisttemplate/{{ $question->checklisttemplate_id }}">Close</a>
                    <button type="submit" class="btn btn-primary pull-right">Update Question</button>
                    </div>
                  </div>
            </form>                                       
        </div>
      </div>
    </div> <!-- Main Panel End -->
    </div>
@endsection