@extends('layouts.app')

@section('content')
    @if ( session()->has('message') )
        <div class="alert alert-success alert-dismissable">{{ session()->get('message') }}</div>
    @endif


    <div class="project-big-box col-md-10 col-md-push-1 col-xs-12 col-xs-push-0">
        <div class="project-hero-img">
            <div id="svg-banner-ingevuld">
                <?xml version="1.0" encoding="utf-8"?>
                <!-- Generator: Adobe Illustrator 19.2.1, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                <svg version="1.1" id="Laag_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                	 viewBox="0 0 78.2 125.5" style="enable-background:new 0 0 78.2 125.5;" xml:space="preserve" width="150" height="150">
                    <style type="text/css">
                    	.st0{fill:#480F0F;}
                    	.st1{fill:#DA291C;}
                    	.st2{fill:#FFFFFF;}
                    	.st3{font-family:'Antwerpen';}
                    	.st4{font-size:49.2952px;}
                    	.st5{font-size:10.1389px;}
                    	.st6{font-size:12px;}
                    </style>
                    <polygon class="st0" points="39.1,99.8 78.2,125.5 78.2,2 39.1,2 0,2 0,125.5 "/>
                    <polygon class="st1" points="39.1,97.8 78.2,123.5 78.2,0 39.1,0 0,0 0,123.5 "/>
                    <text transform="matrix(1 0 0 1 26.9738 60.7319)" class="st2 st3 st4">3</text>
                    <text transform="matrix(1 0 0 1 19.6256 74.0208)" class="st2 st3 st5">ingevuld</text>
                    <text transform="matrix(1 0 0 1 54.8056 61.7318)" class="st2 st3 st6">x</text>
                </svg>


            </div>
            <img src="{{$project->foto}}" alt="">
        </div>

        <article>
            <p>
                @foreach($categorien as $categorie)
                    @if($project->idCategorie == $categorie->idCategorie)
                        <i class="{{$categorie->icon_class}}"></i>{{$categorie->naam}}
                    @endif
                @endforeach

                <!--  VVV VVVVVVVVVVVVVVVVVVV VVV  -->
                <!--  VVV - FIX NEEDED HERE - VVV  -->
                <!--  VVV VVVVVVVVVVVVVVVVVVV VVV  -->

                @if (!Auth::guest() && Auth::user()->role == 10)
                    <a href="/admin/project-bewerken/{{$project->idProject}}" class="bewerken-link pull-right"><i class="fa fa-pencil-square-o"></i>Bewerken</a>
                @endif
            </p>

            <div class="title-with-follow">
                <h1>{{$project->naam}}</h1>
            </div>

            <time> {{ date('d F, Y', strtotime($project->created_at)) }} </time>

            <p>
                {{$project->uitleg}}
            </p>

        </article>

        <a href="#in-progress" class="btn btn-info test pull-left"><i class="fa fa-comments"></i>Geef je mening</a>

        <!--  VVV VVVVVVVVVVVVVVVVVVV VVV  -->
        <!--  VVV - FIX NEEDED HERE - VVV  -->
        <!--  VVV VVVVVVVVVVVVVVVVVVV VVV  -->

        @if (Auth::guest())

        @else
            {{ Form::open(array(
              'url' => Request::fullUrl(),
              'class' => 'form-horizontal',
              'role' => 'form',
              'files' => true)) }}

                @if($isFollowing)
                    <button type="submit" id="following-btn" class="btn btn-success pull-right"><i class="fa fa-check"></i>Aan het volgen</button>
                @else
                    <button type="submit" id="follow-btn" class="btn btn-default pull-right"><i class="fa fa-plus"></i>Project volgen</button>
                @endif

            {{ Form::close() }}
        @endif


    </div>

    <section id="cd-timeline" class="cd-container col-md-10 col-md-push-1 col-xs-12 col-xs-push-0">
        @foreach($phases as $key => $phase)
        	<div class="cd-timeline-block" id="{{$phase->status}}">
        		<div class="cd-timeline-img cd-{{$phase->status}}">
                    <span>#{{$phase->faseNummer}}</span>
        		</div> <!-- cd-timeline-img -->

        		<div class="cd-timeline-content" data-id="{{$phase->idFase}}">
        			<h5>{{$phase->title}}</h5>
        			<p>{{$phase->uitleg}}</p>
        			<span class="cd-date">{{ date('d F, Y', strtotime($phase->start_datum)) }}</span>

                    <?php $isAlreadyAnswered = false; ?>

                    @foreach($AnsweredPhases as $Answeredphase)
                        @if($Answeredphase->idFase == $phase->idFase)
                            <?php $isAlreadyAnswered = true; ?>
                            <?php break; ?>
                        @endif
                    @endforeach

                    @if($phase->status == "in-progress" && !$isAlreadyAnswered)
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
                                                    <label><input type="radio" name="{{$question->idVraag}}" value="Ja" required>Ja</label>
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
                    @elseif($phase->status == "in-progress" && $isAlreadyAnswered)
                       <div class="">
                           <p>
                                <strong>U hebt deze vragen al beantwoord!</strong>
                           </p>
                        </div>
                    @endif
        		</div> <!-- cd-timeline-content -->
        	</div> <!-- cd-timeline-block -->
        @endforeach
	</section> <!-- cd-timeline -->

@endsection
