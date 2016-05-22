@extends('layouts.app')

@section('content')

    <div class="container">
        <div id="#projecten-lijst">
            @foreach($projecten as $project)

                <?php
                    $amountFollowers = 0;
                    $amountAnswers   = 0;
                    $prevUser        = 0;
                ?>

                <div class="project-slice">
                    <a id="info-btn-project-slice" class="btn btn-info pull-right" href="/admin/download/{{$project->idProject}}"><i class="fa fa-download"></i> Download feedback</a>
                    <a id="delete-btn-project-slice" class="btn btn-danger pull-right" href="/admin/project-bewerken/{{$project->idProject}}/verwijderen"><i class="fa fa-trash"></i> Verwijderen</a>

                    <div id="project-round-image" class="round-image" style='background-image: url({{ $project->foto }})'>
                        <div>
                            <a href="/admin/project-bewerken/{{$project->idProject}}"><i class="fa fa-pencil-square-o"></i></a>
                        </div>
                    </div>

                    <h2><a href="/project/{{$project->idProject}}">{{ $project->naam }}</a></h2>

                    @for($i = 0; $i < count($dataProject); $i++)
                        @if($dataProject[$i]->idProject == $project->idProject)
                            <?php
                                $user = $dataProject[$i]->user_id;
                                $userAnswered = $dataProject[$i]->idUser;

                                if($user == $userAnswered){
                                    ++$amountAnswers;
                                }
                            ?>
                        @endif
                    @endfor

                    @for($i = 0; $i < count($usersProject); $i++)
                        @if($usersProject[$i]->project_id == $project->idProject)
                            <?php
                                $user = $usersProject[$i]->user_id;

                                if($user != $prevUser){
                                    ++$amountFollowers;
                                    $prevUser = $user;
                                }
                            ?>
                        @endif
                    @endfor

                    <div class="small-info-box">
                        <h4>Vragen beantwoord:</h4>
                        <p>
                            {{ $amountAnswers }}
                        </p>
                    </div>

                    <div class="small-info-box">
                        <h4>Aantal volgers</h4>
                        <p>
                            {{ $amountFollowers }}
                        </p>
                    </div>

                    <div class="small-info-box">
                        <h4>Voorlopige test</h4>
                        <p>
                            0
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
