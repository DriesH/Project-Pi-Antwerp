@extends('layouts.app')

@section('content')
<div class="container">
  @if ( session()->has('message') )
           <div class="alert alert-success alert-dismissable">{{ session()->get('message') }}</div>
       @endif
    <a href="/admin/project-bewerken/{{$project->idProject}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Terug</a>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Fases van project <em>{{$project->naam}}</em> aanpassen</h2>
                </div>

                <div class="panel-body">

                    @if($fases->count() > 0)

                        <a class="btn btn-success" href="nieuwefase" role="button"><i class="fa fa-plus"></i>Nieuwe fase aanmaken</a>

                        @foreach($fases as $fase)
                            <div class="bs-callout bs-callout-primary"><h3>Fase {{$fase->faseNummer}}: {{$fase->title}}</h3>

                                <p>{{$fase->uitleg}}</p>

                                @if($fase->foto != null)
                                    <img src="/pictures/uploads/{{$fase->foto}}" alt="">
                                @endif

                                <p>Status: <span class="{{$fase->status}}"><strong>{{$fase->status}}</strong></span></p>

                                <a class="btn btn-primary" href="fases/{{$fase->faseNummer}}" role="button"><i class="fa fa-edit"></i>Fase bewerken</a>
                                <a class="btn btn-primary" href="fases/{{$fase->faseNummer}}/vragen" role="button"><i class="fa fa-edit"></i>Vragen bewerken</a>

                                <a class="btn btn-danger pull-right" href="fases/verwijderen/{{$fase->faseNummer}}" role="button"><i class="fa fa-trash"></i>Fase verwijderen</a>
                            </div>
                        @endforeach
                   @else
                       <div>
                           <h4>Er zijn nog geen fases voor dit project.</h4>
                           <a class="btn btn-success" href="nieuwefase" role="button"><i class="fa fa-plus"></i>Nieuwe fase aanmaken</a>
                       </div>
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
