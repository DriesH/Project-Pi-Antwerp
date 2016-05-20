
        {{ Form::label('question_' . $key_questions, $antwoord["antwoord_" . $i], array(
          'class' => 'control-label')) }}
        {{ Form::radio('question_' . $key_questions, $antwoord["antwoord_" . $i], array(
          'class' => 'form-control')) }}
    @endif
@endfor


@foreach($antwoorden as $key_antwoord => $antwoord)
    @if($antwoord->idVraag == $question->idVraag)
        @for( $j = 1; $j < count((array)$antwoord); $j++ )
            <?php  ?>
        @endfor
    @endif
@endforeach
