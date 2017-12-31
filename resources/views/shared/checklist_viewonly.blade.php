<div class="col-md-12">
    <form class="form-horizontal" method="POST" action="/checklist/{{ $checklist->id }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <input type="hidden" name="checklistid" value="{{ $checklist->id }}"> 

        @if ( $checklist->checklist_title == "Model Verification" )
        <table class="table table-striped table-hover">
            <tr>
                <th>Question</th>
                <th>Design</th>
                <th>Submittal</th>
                <th>Delivered</th>
                <th>Comments</th>
            </tr>
            @foreach ( $checklist->questions as $question )
            <input type="hidden" name="questionid-{{ $question->id }}" value="{{ $question->id }}"> 
            <tr class="info">
                <td>{{ $question->question_order}}. {{ $question->question_text}}</td>                         
                <td>{{ $question->answer_design }}</td>
                <td>{{ $question->answer_submitted }}</td>
                <td>{{ $question->answer_installed }}</td>
                <td>{{ $question->answer_comment }}</td>                      
            </tr>
            @endforeach
        </table>
        @else
        <ul class="list-group">
            @foreach ( $checklist->questions as $question )
            <li class="list-group-item">{{ $question->question_order}}. {{ $question->question_text}}
            <div class="input-group">
                <span class="input-group-addon">
                        <input type="checkbox" name="{{$question->id}}-answer_accepted" value="Yes" @if(old("{{$question->id}}-answer_accepted", $question->answer_accepted) == 'Yes' )  checked='checked' @endif readonly>
                </span>
                <input type="text" name="{{$question->id}}-answer_comment" class="form-control" placeholder="Comments" value="{{ $question->answer_comment }}" readonly>
            </div>
            </li>
            @endforeach
        </ul>
        @endif
        <p>
        <a class="btn btn-success btn-sm pull-right" href="/asset/show/{{ $checklist->asset->id }}" role="button"><i class="fa fa-times"></i> Close</a>
        </p> 
            
    {{ Form::close() }}
</div>  