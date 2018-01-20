<div class="col-md-12">
        @if ( $checklist->checklist_title == "Model Verification" )
        <table id="checklisttable" class="table">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Design</th>
                    <th>Submittal</th>
                    <th>Delivered</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $checklist->questions as $question )
                <tr class="accordion-toggle info" data-toggle="collapse" data-target="#collapse{{ $question->id }}" >
                    <td>{{ $question->question_order}}. {{ $question->question_text}}</td>                         
                    <td>{{ $question->answer_design }}</td>
                    <td>{{ $question->answer_submitted }}</td>
                    <td>{{ $question->answer_installed }}</td>                     
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">
                        <div  id="collapse{{ $question->id }}" @if( $question->answer_comment ) class="collapse in" @else class="collapse" @endif >
                        {{ $question->answer_comment }}
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
        <a class="btn btn-success btn-sm pull-right" href="/asset/show/{{ $checklist->asset->id }}" role="button"><i class="fa fa-times"></i> Close</a>
        </p> 
</div>  