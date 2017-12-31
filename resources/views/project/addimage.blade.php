@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
          <!-- Left Menu -->
          <div class="col-md-4">
            <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Project Profile</h3>
            </div>
              <div class="panel-body">
                  <p><img src="/storage/upload/images/{{ $project->thumbnail }}" class="img-rounded" alt="Project Image" width="100%"></p>
                  <p>
                    {{ $project->project_notes }}
                  </p>
                    <ul>
                      <li><strong>Project #:</strong> {{ $project->project_number }}</li>
                      <li><strong>Title:</strong> {{ $project->project_title }}</li>
                      <li><strong>Start Date:</strong> {{ $project->project_start_date }}</li>
                      <li><strong>End Date</strong> {{ $project->project_end_date }}</li>
                      <li><strong>% Complete:</strong> {{ $project->project_percent_complete }}</li>
                      <li><strong>No. of Assets:</strong> {{ $assetscount }}</li>
                      <li><strong>No. of Checklist:</strong> {{ $checklistscount }}</li>
                      <li><strong>No. of Issues:</strong> <a href="/issue/{{ $project->id }}"> {{ $issuescount }}</a></li>
                    </ul> 
                  <p><a class="btn btn-success btn-sm pull-right" href="#" role="button">Edit Project Details &raquo;</a></p>         
              </div>  
            </div>
          </div>
          <!-- Left Menu End -->

          <!-- Main Content (middle panel) -->
          <div class="col-md-8">            
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Change Project Image</h3> 
              </div>
              <div class="panel-body">                   
                        @if(isset($success))
                            <div class="alert alert-success"> {{$success}} </div>
                        @endif
                        {!! Form::open(array('route'=> array('uploadimage', $project->id), 'files'=>true)) !!}

                        <div class="form-group">
                            {!! Form::label('image', 'Choose an image') !!}
                            {!! Form::file('image') !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('image_title', 'Image title:') !!}
                            {!! Form::text('image_title', null, ['class'=>'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('image_description', 'Image description:') !!}
                            {!! Form::textarea('image_description', null, ['class'=>'form-control', 'rows'=>5] ) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Save', array( 'class'=>'btn btn-success form-control' )) !!}
                        </div>

                        {!! Form::close() !!}
                        <div class="alert-warning">
                            @foreach( $errors->all() as $error )
                            <br> {{ $error }}
                            @endforeach
                        </div>                   
              </div>
            </div>
         </div>
        <!-- Main Content (middle panel) End -->


        <!-- Right Info Panel -->

        <!-- Right Info Panel End -->

      </div>
    </div>
</home>
@endsection