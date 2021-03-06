@extends('layouts.app')

@section('content')
<div class="container">
    <a href="/admin" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Terug</a>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Project <em>{{$project->naam}}</em> aanpassen</h1>
                </div>
                <div class="panel-body">
                    {{ Form::open(array(
                      'url' => Request::fullUrl(),
                      'class' => 'form-horizontal',
                      'role' => 'form',
                      'files' => true)) }}

                    <div>
                      @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissable">{{ session()->get('error') }}</div>
                      @endif
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    {!! csrf_field() !!}

                    <div class='form-group'>
                        {{ Form::label('naam','Projectnaam', array(
                            'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::text('naam', $project->naam, array(
                                'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class='form-group'>
                        {{ Form::label('uitleg','Uitleg', array(
                            'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::textarea('uitleg', $project->uitleg, array(
                                'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class='form-group'>
                        {{ Form::label('locatie','Locatie', array(
                            'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::text('locatie', $project->locatie, array(
                                'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class='form-group'>
                       {{ Form::label('foto','Afbeelding', array(
                            'class' => 'col-md-4 control-label',
                            'title' => 'test')) }}
                         <div class="col-md-6">
                            {{ Form::file('foto', array(
                                'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class='form-group'>
                        {{ Form::label('categorie','Selecteer een categorie', array(
                            'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::select('categorie', $categorien, $project->idCategorie,array(
                                'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class='form-group'>
                        {{ Form::label('isActief','Is project actief?', array(
                            'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::checkbox('isActief', '1', $project->isActief, array(
                                'class' => 'checkbox')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i>Aanpassen
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}



                </div>


            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4><i class="fa fa-pencil-square-o"></i>Fases bewerken</h4>
                </div>
                <div class="panel-body">
                    <a class="btn btn-primary center-block" href="{{$project->idProject}}/fases" role="button"><i class="fa fa-edit"></i>Fases en vragen bewerken</a>
                </div>

            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4><img id="small-mascot-icon" src="/pictures/mascot.png" alt="app-mascot" />Appvragen bewerken</h4>
                </div>
                <div class="panel-body">
                    <a class="btn btn-primary center-block" href="{{$project->idProject}}/appvragen" role="button"><i class="fa fa-edit"></i>Appvragen bewerken</a>
                </div>
            </div>


            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h4><i class="fa fa-ban"></i>Gevarenzone!</h4>
                </div>
                <div class="panel-body">
                    <a class="btn btn-danger center-block" href="{{$project->idProject}}/verwijderen" role="button"><i class="fa fa-trash"></i>Project verwijderen</a>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
