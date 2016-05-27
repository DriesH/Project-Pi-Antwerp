@extends('layouts.app')

@section('content')

@if ( session()->has('message') )
  <div class="alert alert-success alert-dismissable">{{ session()->get('message') }}</div>
@endif
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Admin panel</h1>
        </div>
        <div class="panel-body">
            <div class="row col-md-8 col-md-push-2">
                <a class="btn btn-info admin-panel-btn" href="/admin/nieuwproject"><i class="fa fa-plus"></i>Nieuw project toevoegen</a>

                <a class="btn btn-info admin-panel-btn" href="/admin/admin-lijst"><i class="fa fa-pencil-square-o"></i>Admins bewerken</a>

                <a class="btn btn-info admin-panel-btn" href="/admin/project-lijst"><i class="fa fa-list"></i>Lijst van projecten weergeven</a>
            </div>
        </div>
    </div>
</div>
@endsection
