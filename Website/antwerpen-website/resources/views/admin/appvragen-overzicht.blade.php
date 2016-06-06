@extends('layouts.app')

@section('content')
<div class="container">
  @if ( session()->has('message') )
    <div class="alert alert-success alert-dismissable">{{ session()->get('message') }}</div>
  @endif
   <a href="/admin/project-bewerken/{{$project->idProject}}/fases" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Terug</a>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2><ins>Appvragen</ins> van project: <em>{{$project->naam}}</em></h2>
                </div>

                <div class="panel-body">

                    @if($appQuestions->count() > 0)

                        <a class="btn btn-success" href="appvragen/nieuwevraag" role="button"><i class="fa fa-plus"></i>Nieuwe appvraag aanmaken</a>

                        @foreach($appQuestions as $vraag)
                            <div class="bs-callout bs-callout-primary"><h4>{{$vraag->question}}</h4>

                                <a class="btn btn-primary" href="appvragen/{{$vraag->idAppquestions}}" role="button"><i class="fa fa-edit"></i>Appvraag bewerken</a>

                                <a class="btn btn-danger pull-right" href="appvragen/verwijderen/{{$vraag->idAppquestions}}" role="button"><i class="fa fa-trash"></i>Appvraag verwijderen</a>
                            </div>
                        @endforeach
                   @else
                       <div>
                           <h4>Er zijn nog geen appvragen voor dit project.</h4>
                           <a class="btn btn-success" href="appvragen/nieuwevraag" role="button"><i class="fa fa-plus"></i>Nieuwe appvraag aanmaken</a>
                       </div>
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
