@extends('layouts.app')

@section('content')

    <div class="project-wrapper">
       <a href="/" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Terug</a>
        <div class="project-big-box">
            <div class="project-hero-img">
                <img src="{{$project->foto}}" alt="">
            </div>

            <article>
                <p>
                    @foreach($categorien as $categorie)
                        @if($project->idCategorie == $categorie->idCategorie)
                            <i class="{{$categorie->icon_class}}"></i>{{$categorie->naam}}
                        @endif
                    @endforeach
                    @if (!Auth::guest() && Auth::user()->role == 10)
                        <a href="/admin/project-bewerken/{{$project->idProject}}" class="bewerken-link pull-right"><i class="fa fa-pencil-square-o"></i>Bewerken</a>
                    @endif
                </p>
                <div class="title-with-follow">
                    <h1>{{$project->naam}}</h1>

                    @if (Auth::guest())

                    @else
                        {{ Form::open(array(
                          'url' => Request::fullUrl(),
                          'class' => 'form-horizontal',
                          'role' => 'form',
                          'files' => true)) }}

                            @if($isFollowing)
                                <button type="submit" id="following-btn" class="btn btn-success"><i class="fa fa-check"></i>Aan het volgen</button>
                            @else
                                <button type="submit" id="follow-btn" class="btn btn-default"><i class="fa fa-plus"></i>Project volgen</a>
                            @endif

                        {{ Form::close() }}
                    @endif
                </div>
                <time> {{ date('d F, Y', strtotime($project->created_at)) }} </time>
                <p>
                    {{$project->uitleg}}
                </p>
                @if (Auth::guest())
                    <a href="/auth/login" class="btn btn-info"><i class="fa fa-arrow-circle-down"></i>Meld je aan voor je mening te geven</a>
                @else
                    <a href="#{{$project->huidige_fasenr}}" class="btn btn-info"><i class="fa fa-arrow-circle-down"></i>Geef je mening</a>
                @endif
            </article>
        </div>
    </div>

    <section id="cd-timeline" class="cd-container">
        @foreach($phases as $key => $phase)
        	<div class="cd-timeline-block" id="{{$phase->faseNummer}}">
        		<div class="cd-timeline-img cd-{{$phase->status}}">
                    <span>#{{$phase->faseNummer}}</span>
        		</div> <!-- cd-timeline-img -->

        		<div class="cd-timeline-content" data-id="{{$phase->idFase}}">
        			<h5>{{$phase->title}}</h5>
        			<p>{{$phase->uitleg}}</p>
        			<span class="cd-date">{{ date('d F, Y', strtotime($phase->start_datum)) }}</span>

                    @if($project->huidige_fasenr == $phase->faseNummer)
                    <a id="form-reveal" class="btn btn-info"><i class="fa fa-arrow-circle-down"></i>Vul de vragen in!</a>
                    <div class="cd-timeline-question-form" data-id="{{$phase->idFase}}">
                        <h3>Vul de volgende vragen in!</h3>
                        {{ Form::open(array(
                            'url' => '/project/' . $project->idProject,
                            'class' => 'form-horizontal',
                            'role' => 'form',
                            'files' => false)) }}

                                @foreach($questions as $key_questions => $question)
                                    @if($question->idFase == $phase->idFase)
                                        <div class="form-group col-md-12">
                                            {{ Form::label('question_' . $key_questions, $question->vraag, array(
                                                'class' => 'control-label')) }}

                                            @if($question->soort_vraag == "Open")
                                                <div class="form-group col-md-12">
                                                  {{ Form::text('question_' . $key_questions, '', array(
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Antwoord...')) }}
                                                </div>
                                            @elseif($question->soort_vraag == "Ja/Nee")
                                                <div class="form-group col-md-12">
                                                    {{ Form::radio('question_' . $key_questions, 'Ja', array(
                                                      'class' => 'form-control')) }}
                                                    {{ Form::label('question_' . $key_questions, 'Ja', array(
                                                      'class' => 'form-label')) }}


                                                </div>
                                                <div class="form-group col-md-12">
                                                    {{ Form::radio('question_' . $key_questions, 'Nee', array(
                                                      'class' => 'form-control')) }}
                                                    {{ Form::label('question_' . $key_questions, 'Nee', array(
                                                      'class' => 'form-label')) }}
                                                </div>
                                            @elseif($question->soort_vraag == "Meerkeuze")
                                                @foreach($antwoorden as $key_antwoord => $antwoord)
                                                    @if($antwoord->idVraag == $question->idVraag)
                                                        @for( $j = 1; $j < 5;  $j++)
                                                            <div class="form-group col-md-12">
                                                                {{ Form::radio('question_' . $question->idVraag, $antwoord->{'antwoord_' . $j}, array(
                                                                      'class' => 'form-control')) }}
                                                                {{ Form::label('question_' . $question->idVraag, $antwoord->{'antwoord_' . $j}, array(
                                                                       'class' => 'form-label')) }}
                                                            </div>
                                                        @endfor
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                @endforeach

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success form-control">
                                            <i class="fa fa-paper-plane"></i> Vragen verzenden
                                        </button>
                                    </div>
                                </div>
                        {{ Form::close() }}
                    </div>
                    @endif
        		</div> <!-- cd-timeline-content -->
        	</div> <!-- cd-timeline-block -->
        @endforeach
	</section> <!-- cd-timeline -->
@endsection
