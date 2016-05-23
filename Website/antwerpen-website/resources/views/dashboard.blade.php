@extends('layouts.app')

@section('content')

<div class="container" id="dashboard">
    <a href="/" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Terug</a>

    <h1>Profiel gegevens.</h1>


    <div class="panel panel-default profile-box col-md-3 col-sm-3 col-xs-12">
        <img class="profile-picture-big center-block" src="/pictures/a-logo.svg" alt="" />
        <p>
            {{Auth::user()->name}}
        </p>
        <p>
            {{Auth::user()->email}}
        </p>
    </div>

    <div class="col-md-9 col-sm-9 col-xs-12" id="information-panel">
        <div class="panel panel-default">
            <div class="panel-heading profile-heading">
                <h3><i class="fa fa-bar-chart"></i>Gevolgde projecten</h3>
            </div><!--panel-heading-->

            <div class="panel-body">
                @foreach($projects as $project)
                <div class="media">

                        <div class="media-left media-top">
                            <a href="#">
                                <img class="media-object profile-picture-small" src="/pictures/a-logo.svg" alt="a-logo">
                            </a>
                        </div><!--media-left-->

                        <div class="media-body">

                                <h4 class="media-heading"><a href='/project/{{ $project->idProject }}' id="project-link"> Project: {{ $project->naam }}</a></h4>
                                <p>
                                    {{ $project->uitleg }}
                                </p>

                        </div><!--media-body-->

                </div><!--media-->
                @endforeach
            </div><!--panel-body-->
        </div><!--panel-->
    </div><!--col-md-9-->
</div><!--container-->

@endsection
