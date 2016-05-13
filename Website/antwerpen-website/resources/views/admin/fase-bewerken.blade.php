@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                <h3>Fase {{$fase->faseNummer}} van project <ins>{{$project->naam}}</ins>:  aanpassen</h3>
                </div>
                <div class="panel-body">
                    {{ Form::open(array(
                      'url' => Request::fullUrl(),
                      'class' => 'form-horizontal',
                      'role' => 'form',
                      'files' => true)) }}

                    <div>
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

                    <div class="form-group">
                       {{ Form::label('title','Fasenaam', array(
                          'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::text('title', $fase->title, array(
                              'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                       {{ Form::label('uitleg','Uitleg', array(
                          'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::textarea('uitleg', $fase->uitleg, array(
                              'class' => 'form-control')) }}
                        </div>
                    </div>

                    <!--
                    <div>
                        {{ Form::label('foto','Afbeelding', array(
                          'class' => 'col-md-4 control-label',
                          'title' => 'test')) }}
                        <div class="col-md-6">
                            {{ Form::file('foto', array(
                              'class' => 'form-control')) }}
                        </div>
                    </div>
                    -->

                    <div class="form-group">
                        {{ Form::label('status','Selecteer een status', array(
                          'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::select('status', ['not-started' => 'not-started', 'in-progress' => 'in-progress', 'done' =>    'done'],$fase->status, array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('start_datum','Selecteer de startdatum (jjjj-mm-dd)', array(
                          'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            <div class="input-group date">
                                {{ Form::text('start_datum', substr($fase->start_datum, 0, 10), array(
                                  'class' => 'form-control',
                                  'placeholder' => 'jjjj/dd/mm')) }}<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
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
        </div>
    </div>
</div>
@endsection
