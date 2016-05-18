@extends('layouts.app')

@section('content')
<div class="container">
   <a href="vragen" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Terug</a>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                <h3>Niewe vraag aanmaken voor fase {{$fase->faseNummer}}: <ins>{{$fase->title}}</ins> van project <ins>{{$project->naam}}</ins></h3>
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
                        {{ Form::label('vraag','Vraag', array(
                          'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::text('vraag', '',array(
                              'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('soort_vraag','Selecteer een vraagsoort', array(
                          'class' => 'col-md-4 control-label')) }}
                        <div class="col-md-6">
                            {{ Form::select('soort_vraag', ['Open' => 'Open', 'Ja/Nee' => 'Ja/Nee', 'Meerkeuze' => 'Meerkeuze'],null, array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i>Toevoegen
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
