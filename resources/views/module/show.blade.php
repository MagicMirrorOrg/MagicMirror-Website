@extends('layouts.app')

@section('content')

    <show-module :module='{!!$module->toJSON()!!}'></show-module>

@endsection
