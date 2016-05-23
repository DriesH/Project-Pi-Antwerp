@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ URL::previous() }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Terug</a>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading"><h3>Bent u zeker dat u project: <em>{{$project->naam}}</em> wilt verwijderen?</h3>
                </div>
                <div class="panel-body">
                    <div class="bs-callout bs-callout-danger"><h3>{{$project->naam}}</h3>
                    <p>{{ str_limit($project->uitleg, $limit = 250, $end='...')  }}</p>
                    {{ Form::open(array(
                      'url' => Request::fullUrl(),
                      'class' => 'form-horizontal',
                      'role' => 'form',
                      'files' => true)) }}

                    <a class="btn btn-warning" href="/admin/project-bewerken/{{$project->idProject}}" role="button"><i class="fa fa-ban"></i>Annuleren</a>
                    <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash"></i>Project Verwijderen</button>

                       {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
