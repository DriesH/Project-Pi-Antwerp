@extends('layouts.app')

@section('content')

    <div class="container">
        <div id="#projecten-lijst">
            @foreach($projecten as $project)
                <div class="jumbotron project-slice">
                    <div class="media">
                        <div class="round-image media-left media-middle" style='background-image: url({{ $project->foto }})'>
                            <div>
                                <a href="/admin/project-bewerken/{{$project->idProject}}"><i class="fa fa-pencil-square-o"></i></a>
                            </div>
                        </div>

                        <div class="media-body">
                            <h2><a href="/project/{{$project->idProject}}">{{ $project->naam }}</a></h2>
                        </div>
                        <button id="info-btn-project-slice" class="btn btn-success pull-right" type="button" name="button"><i class="fa fa-info-circle"></i> Info</button>
                        <button id="delete-btn-project-slice" class="btn btn-danger pull-right" type="button" name="button"><i class="fa fa-trash"></i>Delete</button>
                    </div>


                </div>
            @endforeach
        </div>
    </div>

@endsection
