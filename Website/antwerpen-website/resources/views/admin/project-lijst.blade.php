@extends('layouts.app')

@section('content')

    <div class="container admin-project-lijst-col">
        <a href="/admin" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Terug</a>
        <div id="#projecten-lijst">
            @foreach($projecten as $project)

                <?php
                    $amountFollowers = 0;
                    $amountAnswers   = 0;
                    $prevUser        = 0;
                ?>

                <div class="project-slice">

                    <a id="delete-btn-project-slice" class="btn btn-danger pull-right" href="/admin/project-bewerken/{{$project->idProject}}/verwijderen"><i class="fa fa-trash"></i> Verwijderen</a>
                    <a id="download-btn-project-slice" class="btn btn-default pull-right" href="/admin/download/{{$project->idProject}}"><i class="fa fa-download"></i> Download feedback</a>

                    <div id="project-round-image" class="round-image" style='background-image: url({{ $project->foto }})'>
                        <div>
                            <a href="/admin/project-bewerken/{{$project->idProject}}">bewerken</a>
                        </div>
                    </div>

                    <div class="titel-time-adminpanel">
                        <h2><a href="/project/{{$project->idProject}}">{{ $project->naam }}</a></h2>
                        <time><strong>Aangemaakt:</strong> {{ Date::parse($project->created_at)->format('j F Y') }}</time>
                    </div>

                    @for($i = 0; $i < count($dataProject); $i++)
                        @if($dataProject[$i]->idProject == $project->idProject)
                            <?php
                                ++$amountAnswers;
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
                        <h4>Vragen beantwoord</h4>
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
                        <h4>Project actief</h4>
                        <p>
                            @if($project->isActief)
                                <i class="fa fa-check" id="actief-vinkje"></i>
                            @else
                                <i class="fa fa-times" id="disable-vinkje"></i>
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
