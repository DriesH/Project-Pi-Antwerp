@extends('layouts.app')

@section('content')

  @if ( isset($message) )
    <div class="alert alert-success alert-dismissable">{{ $message }}</div>
  @elseif(isset($error))
    <div class="alert alert-danger alert-dismissable">{{ $error }}</div>
  @endif
  
  <div class="panel panel-default">
      <div class="panel-heading">
          <h1>Admin lijst</h1>
      </div>
      <div class="panel-body container">
          <div class="row">
              {{ Form::open(array(
                'url' => Request::fullUrl(),
                'class' => 'form-horizontal',
                'role' => 'form')) }}

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

                <div class="input-group">
                        {{ Form::text('admin', '',array(
                          'class' => 'form-control',
                          'placeholder' => 'Naam of email van nieuwe admin...')) }}
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-primary">
                              <i class="fa fa-btn fa-sign-in"></i>Maak admin
                          </button>
                        </span>
                </div>
                {{ Form::close() }}

                <div class="bs-callout bs-callout-primary">
                  <h4>Huidige administrators</h4>
                  <div class="admin-info">
                    @foreach($admins as $admin)
                      <p>
                        Naam:<strong>{{$admin->name}}</strong>
                      </p>
                      <p>
                        E-mail:<strong>{{$admin->email}}</strong>
                      </p>
                    @endforeach
                  </div>

                </div>
        </div>
    </div>

</div>
@endsection
