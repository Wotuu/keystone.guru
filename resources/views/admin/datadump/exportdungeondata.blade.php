@extends('layouts.app')

@section('header-title', __('Dump dungeon data'))

@section('content')

    {{ Form::open(['route' => 'admin.datadump.viewexporteddungeondata']) }}

    {!! Form::submit(__('Submit'), ['class' => 'btn btn-info']) !!}

    {!! Form::close() !!}
@endsection