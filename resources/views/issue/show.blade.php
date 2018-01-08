@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
        <!-- left menu       -->

        <!-- left menu end -->

      <div class="col-md-9">
          <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Issue Profile
                <a class="pull-right" href="/home"><i class="fa fa-home"> | </i></a>
                <a class="pull-right" href="/issue/{{ $issue->id }}/edit"><i class="fa fa-pencil"> | </i></a>
                <a class="pull-right" href="#"><i class="fa fa-trash"> | </i></a>  
                <a class="pull-right" href="#"><i class="fa fa-print"> | </i></a>
            </h3> 
          </div>
          
            <div class="panel-body">

             <h4>Issue {{ $issue->id }} - {{ $issue->issue_title }}</h4>

             <p>
                <strong>Issue Type:</strong> {{ $issue->issue_type }}</br>
                <strong>Date Found:</strong> {{ $issue->issue_created_date }}</br>
                <strong>Entered by:</strong> {{ $issue->user->name }}</br>
                <strong>Response Due Date:</strong> {{ $issue->issue_response_date }}</br>
                <strong>Responsible:</strong> {{ $issue->issue_response_person }}</br>
                <strong>Priority:</strong> <span class="label label-danger"> {{ $issue->issue_priority }}</span></br>
                <strong>Status:</strong> <span class="label label-warning">{{ $issue->issue_status }} </span></br>
                <strong>Date Added:</strong> {{ $issue->created_at->toFormattedDateString() }}</br>
                <strong>Date Last Updated:</strong> {{ $issue->updated_at->toFormattedDateString() }}</br>

                <hr>

                Description
                <div class="well well-md">
                 {{ $issue->issue_description }}
                 </div>

                Recommendation
                 <div class="well well-md">
                 {{ $issue->issue_recommendation }}
                </div>

                Resolution
                 <div class="well well-md">
                 {{ $issue->issue_resolution }}
                </div>
            </p>

              <div class="panel panel-default">
                <div class="panel-heading">Photos of Issue </div>
                <div class="panel-body">                 
                        <div class="row">
                          @foreach ($photos as $photo)
                            <div class="col-md-4">
                              <div class="thumbnail">
                                <a href="/{{ $photo->image_filepath }}" target="_blank">
                                  <img src="/{{ $photo->image_filepath }}" alt="photo" style="width:100%">
                                  <div class="caption">
                                    <p>
                                    {{ $photo->image_description }}
                                    <form action="{{ url('issue/photo/'.$photo->id) }}" method="POST" class="form-inline">
                                      {{ csrf_field() }}
                                      {{ method_field('DELETE') }}

                                      <button type="submit" id="delete-photo-{{ $photo->id }}" class="btn btn-sm btn-danger">
                                      <i class="fa fa-btn fa-trash"></i> </button>
                                    </form>
                                    </p>
                                  </div>
                                </a>
                              </div>
                            </div>
                            @endforeach                        
                        </div>
                                  
                 
                </div>
              </div>

               <p><h4>Responses</h4> 
                <hr>

                @foreach ($issue->issuecomments as $comment)
                <div class="media">
                  <div class="media-left">                   
                      <img class="media-object" src="/img/avatar-user-1.jpg" alt="profile pic" style="width:45px">                   
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading">{{ $comment->comment_title }} - <small>by {{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}</small></h4>
                    <p> {{ $comment->comment_body }}
                    <a href="#" role="button" ><i class="fa fa-comment-o"></i> </a> </p>
                  </div>
                </div>
                @endforeach
               </p>
              <hr>
              <p>
                <form class="form-horizontal" method="POST" action="/comment/{{ $issue->id }}">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <label for="comment_title" class="col-sm-2 control-label">Comment Title</label>
                      <div class="col-sm-10">
                    <input type="text" name="comment_title" class="form-control" id="comment_title" placeholder="Comment Title"></input>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="comment_body" class="col-sm-2 control-label">Comment Details</label>
                      <div class="col-sm-10">
                    <textarea name="comment_body" class="form-control" id="comment_body" placeholder="Comment Details"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary pull-right">Add Comment</button>
                    </div>
                  </div>
                </form>
              </p>

              <p>
                <a href="/issue" class="btn btn-info">exit</a>                
              </p>
                                           
            </div>
            <div class="panel-footer">
              <nav aria-label="Page navigation">
                <ul class="pagination">
                  <li>
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                  <li>
                  </ul>
                  
                
              </nav>
            </div>
          </div>

        </div>
        <!-- Right Info Panel -->
        @include('shared.leftmenu')
        <!-- Right Info Panel End -->
      </div>
    </div>
</home>

<!-- Modal -->
<div id="photoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Photo</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/issue/{{$issue->id}}/addphoto" enctype="multipart/form-data">
                   {{ csrf_field() }}

                  <div class="form-group">
                    <label for="image" class="col-md-2 control-label">Upload Image</label>
                    <div class="col-md-10">
                      <input class="form-control" type="file" name="image">
                    </div>
                  </div>

                    <div class="form-group">
                    <label for="image_title" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                    <input type="text" name="image_title" id="image_title" class="form-control" ></input>
                    </div>
                    </div>

                    <div class="form-group">
                    <label for="image_description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                    <textarea name="image_description" class="form-control" id="image_description" placeholder="Describe the project" ></textarea>
                    </div>
                    </div>

                    <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary pull-right">Upload Photo</button>
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
@endsection