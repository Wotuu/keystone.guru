@extends('layouts.sitepage', ['showAds' => false, 'title' => __('Admin tools')])

@section('header-title', __('Admin tools'))

@section('content')
    <h3>{{ __('Tools') }}</h3>
    <h4>{{ __('Import') }}</h4>
    <div class="form-group">
        <a href="{{ route('admin.tools.npcimport') }}">{{ __('Mass import NPCs') }}</a>
    </div>

    <h4>{{ __('Dungeonroute') }}</h4>
    <div class="form-group">
        <a href="{{ route('admin.tools.dungeonroute.view') }}">{{ __('View Dungeonroute details') }}</a>
    </div>

    <h4>{{ __('MDT') }}</h4>
    <div class="form-group">
        <a href="{{ route('admin.tools.mdt.string.view') }}">{{ __('View MDT String contents') }}</a>
    </div>
    <div class="form-group">
        <a href="{{ route('admin.tools.mdt.string.viewasdungeonroute') }}">{{ __('View MDT String as Dungeonroute') }}</a>
    </div>
    <div class="form-group">
        <a href="{{ route('admin.tools.mdt.dungeonroute.viewasstring') }}">{{ __('View Dungeonroute as MDT String') }}</a>
    </div>
    <div class="form-group">
        <a href="{{ route('admin.tools.mdt.diff') }}">{{ __('View MDT Diff') }}</a>
    </div>

    <h4>{{ __('Misc') }}</h4>
    <div class="form-group">
        <a href="{{ route('admin.tools.cache.drop') }}">{{ __('Drop caches') }}</a>
    </div>
    <div class="form-group">
        <a href="{{ route('admin.tools.exception.select') }}">{{ __('Throw an exception') }}</a>
    </div>
    <h3>{{ __('Actions') }}</h3>
    <div class="form-group">
        <a class="btn btn-primary" href="{{ route('admin.tools.datadump.exportdungeondata') }}">{{ __('Export dungeon data') }}</a>
    </div>
    <div class="form-group">
        <a class="btn btn-primary" href="{{ route('admin.tools.datadump.exportreleases') }}">{{ __('Export releases') }}</a>
    </div>
@endsection