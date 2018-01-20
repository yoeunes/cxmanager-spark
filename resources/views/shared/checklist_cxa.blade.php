<div class="col-md-12">
<form class="form-horizontal" method="POST" action="/checklist/{{ $checklist->id }}">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <input type="hidden" name="checklistid" value="{{ $checklist->id }}"> 

    @if ( $checklist->checklist_title == "Model Verification" )
    <table id="checklisttable" class="table">
        <thead><tr>
            <th>Question</th>
            <th>Design</th>
            <th>Submittal</th>
            <th>Delivered</th>
            </tr>
        </thead> 
        <tbody>     
            @foreach ( $checklist->questions as $question )
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
        @foreach ( $checklist->questions as $question )
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
    <a class="btn btn-success btn-sm pull-right" href="/asset/show/{{ $checklist->asset->id }}" role="button"><i class="fa fa-times"></i> Close</a>
    </p> 
        
{{ Form::close() }}
</div>  