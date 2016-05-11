@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Bent u zeker dat u project: {{$project->naam}} wilt verwijderen?</h3>
                </div>
                <div class="panel-body">
                    <div class="bs-callout bs-callout-primary"><h3>{{$project->naam}}</h3>
                    <p>{{$project->uitleg}}</p>
                    {{ Form::open(array(
                      'url' => Request::fullUrl(),
                      'class' => 'form-horizontal',
                      'role' => 'form',
                      'files' => true)) }}  
                    <button type="submit" class="btn btn-danger"><i class="fa fa-edit"></i>Project Verwijderen</button>
                    <a class="btn btn-default" href="/admin/project-bewerken/{{$project->idProject}}" role="button"><i class="fa fa-edit"></i>Annuleren</a>
                       {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
