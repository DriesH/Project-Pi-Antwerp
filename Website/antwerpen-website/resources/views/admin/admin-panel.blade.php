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
                    <a class="btn btn-info center-block" href="/admin/nieuwproject"><i class="fa fa-plus"></i>Nieuw project toevoegen</a>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <a class="btn btn-info center-block" href="/admin/lijst"><i class="fa fa-pencil-square-o"></i>Admins bewerken</a>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <a class="btn btn-info center-block" href="/admin/verwijderproject"><i class="fa fa-list"></i>Lijst van projecten weergeven</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
