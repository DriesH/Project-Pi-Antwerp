@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Bent u zeker dat u deze vraag van project: {{$project->naam}} wilt verwijderen?</h3>
                </div>
                <div class="panel-body">
                      <div class="bs-callout bs-callout-primary">
                        <h4>{{$appquestion->question}}</h4>
                    {{ Form::open(array(
                      'url' => Request::fullUrl(),
                      'class' => 'form-horizontal',
                      'role' => 'form')) }}
                    <button type="submit" class="btn btn-danger"><i class="fa fa-edit"></i>Appvraag verwijderen</button>
                    <a class="btn btn-default" href="/admin/project-bewerken/{{$project->idProject}}/appvragen" role="button"><i class="fa fa-edit"></i>Annuleren</a>
                       {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
