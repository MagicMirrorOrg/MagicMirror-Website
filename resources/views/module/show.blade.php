@extends('layouts.app')

@section('content')

    <div class="jumbotron">
        <div class="container">
            <h1>{{$module->name}}</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <readme-viewer module-url="{{$module->github_url}}"></readme-viewer>
            </div>
        </div>
    <div>

@endsection
