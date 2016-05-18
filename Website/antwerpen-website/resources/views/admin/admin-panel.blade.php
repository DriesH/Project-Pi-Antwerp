@extends('layouts.app')

@section('content')

@if ( session()->has('message') )
  <div class="alert alert-success alert-dismissable">{{ session()->get('message') }}</div>
@endif
<div class="panel panel-default">
    <div class="panel-heading">
        <h1>Admin panel</h1>
    </div>
    <div class="panel-body container">
        <div class="row">
            <div class="col-md-4">
                <div>
                    <a class="btn btn-success center-block" href="/admin/nieuwproject"><i class="fa fa-plus"></i>Nieuw project toevoegen</a>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <a class="btn btn-warning center-block" href="/admin/"><i class="fa fa-pencil-square-o"></i>Project wijzigen</a>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <a class="btn btn-danger center-block" href="/admin/verwijderproject"><i class="fa fa-trash-o"></i>Project verwijden</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="map">

    </div>

</div>
@endsection
