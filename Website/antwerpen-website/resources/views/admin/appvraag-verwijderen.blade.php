@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ URL::previous() }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Terug</a>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3>Bent u zeker dat u deze vraag van project: <em>{{$project->naam}}</em> wilt verwijderen?</h3>
                </div>
                <div class="panel-body">
                      <div class="bs-callout bs-callout-danger">
                        <h3>{{$appquestion->question}}</h3>
                        {{ Form::open(array(
                          'url' => Request::fullUrl(),
                          'class' => 'form-horizontal',
                          'role' => 'form')) }}
                            <a class="btn btn-warning" href="/admin/project-bewerken/{{$project->idProject}}/appvragen" role="button"><i class="fa fa-ban"></i>Annuleren</a>
                            <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash"></i>Appvraag verwijderen</button>
                            
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
