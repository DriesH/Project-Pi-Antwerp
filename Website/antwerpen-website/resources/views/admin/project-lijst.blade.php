@extends('layouts.app')

@section('content')

    <div class="container">
        <div id="#projecten-lijst">
            @foreach($projecten as $project)
                <div class="project-slice">
                    <button id="info-btn-project-slice" class="btn btn-info pull-right" type="button" name="button"><i class="fa fa-info-circle"></i> Uitgebreide info</button>
                    <button id="delete-btn-project-slice" class="btn btn-danger pull-right" type="button" name="button"><i class="fa fa-trash"></i> Verwijderen</button>

                    <div id="project-round-image" class="round-image" style='background-image: url({{ $project->foto }})'>
                        <div>
                            <a href="/admin/project-bewerken/{{$project->idProject}}"><i class="fa fa-pencil-square-o"></i></a>
                        </div>
                    </div>



                    <h2><a href="/project/{{$project->idProject}}">{{ $project->naam }}</a></h2>

                    @for($i = 0; $i < count($dataProject); $i++)
                        @if($dataProject[$i]->idProject == $project->idProject)

                            <?php ++$amountAnswers ?>

                        @endif
                    @endfor

                    <div class="small-info-box">
                        <h4>Vragen beantwoord:</h4>
                        <p>
                            {{$amountAnswers}}
                        </p>
                    </div>

                    <div class="small-info-box">
                        <h4>test</h4>
                        <p>
                            {{$amountAnswers}}
                        </p>
                    </div>

                    <div class="small-info-box">
                        <h4>test</h4>
                        <p>
                            {{$amountAnswers}}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
