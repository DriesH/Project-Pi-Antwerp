@extends('layouts.app')

@section('content')
  @if ( session()->has('message') )
    <div class="alert alert-success alert-dismissable">{{ session()->get('message') }}</div>
  @endif
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
                    <a href="#in-progress" class="btn btn-info"><i class="fa fa-arrow-circle-down"></i>Geef je mening</a>
            </article>
        </div>
    </div>

    <section id="cd-timeline" class="cd-container">
        @foreach($phases as $key => $phase)
        	<div class="cd-timeline-block" id="{{$phase->status}}">
        		<div class="cd-timeline-img cd-{{$phase->status}}">
                    <span>#{{$phase->faseNummer}}</span>
        		</div> <!-- cd-timeline-img -->

        		<div class="cd-timeline-content" data-id="{{$phase->idFase}}">
        			<h5>{{$phase->title}}</h5>
        			<p>{{$phase->uitleg}}</p>
        			<span class="cd-date">{{ date('d F, Y', strtotime($phase->start_datum)) }}</span>

                    @if($phase->status == "in-progress")
                    <a id="form-reveal" class="btn btn-info"><i class="fa fa-arrow-circle-down"></i>Vul de vragen in!</a>
                    <div class="cd-timeline-question-form" data-id="{{$phase->idFase}}">
                        <h3>Uw mening telt!</h3>
                        {{ Form::open(array(
                            'url' => '/project/' . $project->idProject . '/done',
                            'class' => 'form-horizontal',
                            'role' => 'form',
                            'files' => false)) }}

                                @foreach($questions as $key_questions => $question)
                                    @if($question->idFase == $phase->idFase)
                                        <div class="form-group col-md-12">
                                            {{ Form::label($question->idVraag, $question->vraag, array(
                                                'class' => 'control-label')) }}

                                            @if($question->soort_vraag == "Open")
                                                <div class="form-group col-md-12">
                                                  {{ Form::text($question->idVraag, '', array(
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Antwoord...',
                                                    'required' => 'required',
                                                    'maxlength' => 100 )) }}
                                                </div>
                                            @elseif($question->soort_vraag == "Ja/Nee")
                                                <div class="form-group col-md-12">
                                                  <div class="radio">
                                                    <label><input type="radio" name="{{$question->idVraag}}" value="Nee" required>Ja</label>
                                                  </div>
                                                  <div class="radio">
                                                      <label><input type="radio" name="{{$question->idVraag}}" value="Nee" required>Nee</label>
                                                  </div>
                                                </div>
                                            @elseif($question->soort_vraag == "Meerkeuze")
                                                @foreach($antwoorden as $key_antwoord => $antwoord)
                                                    @if($antwoord->idVraag == $question->idVraag)
                                                        @for( $j = 1; $j < 5;  $j++)
                                                          @if($antwoord->{'antwoord_' . $j} != null && $antwoord->{'antwoord_' . $j} != "")
                                                            <div class="form-group col-md-12">
                                                              <div class="radio">
                                                                  <label><input type="radio" name="{{$question->idVraag}}" value="{{ $antwoord->{'antwoord_' . $j} }}" required>{{ $antwoord->{'antwoord_' . $j} }}</label>
                                                              </div>
                                                            </div>
                                                          @endif

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
