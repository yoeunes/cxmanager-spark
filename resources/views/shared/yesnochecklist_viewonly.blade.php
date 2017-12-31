<ul class="list-group">
    @foreach ( $checklist->questions as $question )
    <li class="list-group-item"> {{ $question->question_text}}
    <div class="input-group">
        <span class="input-group-addon">
                <input type="checkbox" name="{{$question->id}}-answer_accepted" value="Yes" @if(old("{{$question->id}}-answer_accepted", $question->answer_accepted) == 'Yes' )  checked='checked' @endif readonly>
        </span>
        <input type="text" name="{{$question->id}}-answer_comment" class="form-control" placeholder="Comments" value="{{ $question->answer_comment }}" readonly>
    </div>
    </li>
    @endforeach
</ul>