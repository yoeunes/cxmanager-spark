@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
          <div class="col-md-3">
            <div class="panel panel-success">
              <div class="panel-heading">
                <h3 class="panel-title">{{ $project->project_title }}</h3>
              </div>
              <div class="panel-body">
                  <p><img src="/storage/upload/images/{{ $project->thumbnail }}" class="img-rounded" alt="Project Image" width="100%"></p>
                  <p>
                    {{ $project->project_notes }}
                  </p>
                  <p><a class="btn btn-success btn-sm pull-right" href="/home" role="button">Project Home &raquo;</a></p>         
              </div>  
            </div>
          </div>
      
      <div class="col-md-9"> <!-- Main Panel Start -->
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Edit Question
              </h3> 
            </div>

            <div class="panel-body">
               <form class="form-horizontal" method="POST" action="/question/{{ $question->id }}">
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
                        <a class="btn btn-danger btn-sm" href="/checklist/{{ $question->checklist_id }}">Close</a>
                        <button type="submit" class="btn btn-primary pull-right">Update Question</button>
                        </div>
                      </div>
                </form>                                       
            </div>
          </div>
        </div> <!-- Main Panel End -->
        </div>
      </div>
</home>
@endsection