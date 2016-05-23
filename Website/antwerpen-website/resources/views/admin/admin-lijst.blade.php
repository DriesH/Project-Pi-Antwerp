@extends('layouts.app')

@section('content')

  @if ( isset($message) )
    <div class="alert alert-success alert-dismissable">{{ $message }}</div>
  @elseif(isset($error))
    <div class="alert alert-danger alert-dismissable">{{ $error }}</div>
  @endif
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Admin lijst</h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    {{ Form::open(array(
                      'url' => Request::fullUrl(),
                      'class' => 'form-horizontal',
                      'role' => 'form')) }}


                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                {!! csrf_field() !!}

                <div class="col-md-6 col-md-push-3">
                    <div class="input-group">
                        {{ Form::text('admin', '',array(
                          'class' => 'form-control',
                          'placeholder' => 'Naam of email van nieuwe admin...')) }}
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">
                                <i class="fa fa-btn fa-sign-in"></i>Maak admin
                            </button>
                        </span>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->


                {{ Form::close() }}

                <div class="col-md-12">
                    @foreach($admins as $admin)
                        <div class="bs-callout bs-callout-primary col-md-12">
                            <h4>Huidige administrators</h4>
                            <p>
                                Naam: <strong>{{$admin->name}}</strong>
                            </p>
                            <p>
                                E-mail: <strong>{{$admin->email}}</strong>
                            </p>
                            @if(Auth::user()->id != $admin->id)
                                <a href="admin-lijst/verwijderen/{{$admin->id}}">
                                    <button class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash-o"></i>Verwijderen als administrator
                                    </button>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
