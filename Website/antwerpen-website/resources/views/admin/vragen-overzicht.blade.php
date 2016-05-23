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
                <div class="panel-heading"><h2><ins>Vragen</ins> Fase {{$fase->faseNummer}}: <em>{{$fase->title}}</em> - Project: <em>{{$project->naam}}</em> aanpassen</h2>
                </div>

                <div class="panel-body">

                    @if($vragen->count() > 0)

                        <a class="btn btn-success" href="nieuwevraag" role="button"><i class="fa fa-plus"></i>Niewe vraag aanmaken</a>

                        @foreach($vragen as $vraag)
                            <div class="bs-callout bs-callout-primary"><h4>{{$vraag->vraag}}</h4>

                                <p>soort vraag: <strong>{{$vraag->soort_vraag}}</strong></p>

                                <a class="btn btn-primary" href="vragen/{{$vraag->idVraag}}" role="button"><i class="fa fa-edit"></i>Vraag bewerken</a>

                                <a class="btn btn-danger pull-right" href="vragen/verwijderen/{{$vraag->idVraag}}" role="button"><i class="fa fa-trash"></i>Vraag verwijderen</a>
                            </div>
                        @endforeach
                   @else
                       <div>
                           <h4>Er zijn nog geen vragen voor deze fases.</h4>
                           <a class="btn btn-success" href="nieuwevraag" role="button"><i class="fa fa-plus"></i>Niewe vraag aanmaken</a>
                       </div>
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
