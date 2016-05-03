@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Project toevoegen</h1></div>
                <div class="panel-body">                       
                    {{ Form::open(array(
                      'action' => 'AdminController@postNieuwProject',
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

                        <!--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">-->
                        <div>   
                           {{ Form::label('naam','Projectnaam', array(
                                'class' => 'col-md-4 control-label')) }}       
                            <div class="col-md-6">
                                {{ Form::text('naam', '', array(
                                'class' => 'form-control')) }}
                                <!--@if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif-->
                            </div>
                        </div>
                        
                        <div>
                           {{ Form::label('uitleg','Uitleg', array(
                                'class' => 'col-md-4 control-label')) }} 
                            <div class="col-md-6">
                              {{ Form::textarea('uitleg', '', array(
                                'class' => 'form-control')) }} 
                            </div>                    
                        </div>
                        
                        <div>
                            {{ Form::label('locatie','Locatie', array(
                                'class' => 'col-md-4 control-label')) }} 
                             <div class="col-md-6"> 
                              {{ Form::text('locatie', '', array(
                                'class' => 'form-control')) }}
                            </div>
                        </div>
                        
                        <div>
                           {{ Form::label('foto','Afbeelding', array(
                                'class' => 'col-md-4 control-label')) }} 
                             <div class="col-md-6"> 
                              {{ Form::file('foto', array(
                                'class' => 'form-control')) }}
                            </div>
                        </div>
                        
                        <div>
                           {{ Form::label('isActief','Is project actief?', array(
                                'class' => 'col-md-4 control-label')) }} 
                             <div class="col-md-6"> 
                              {{ Form::checkbox('isActief', '1', false,array(
                                'class' => 'form-control')) }}
                                </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Aanmaken
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
