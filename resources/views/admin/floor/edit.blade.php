<?php
/** @var $dungeon \App\Models\Dungeon */
/* @var $floor \App\Models\Floor */
/* @var $floorCouplings \App\Models\FloorCoupling[]|\Illuminate\Support\Collection */
$connectedFloorCandidates = $dungeon->floors;
if (isset($floor)) {
    $connectedFloorCandidates = $connectedFloorCandidates->except(optional($floor)->id);
}
?>
@extends('layouts.sitepage', ['breadcrumbsParams' => [$dungeon, $floor ?? null], 'showAds' => false, 'title' => $headerTitle])
@section('header-title')
    {{ $headerTitle }}
@endsection
<?php
/**
 */
?>

@section('content')
    @isset($floor)
        {{ Form::model($floor, ['route' => ['admin.floor.update', 'dungeon' => $dungeon->getSlug(), 'floor' => $floor->id], 'method' => 'patch']) }}
    @else
        {{ Form::open(['route' => ['admin.floor.savenew', 'dungeon' => $dungeon->getSlug()]]) }}
    @endisset

    <div class="form-group{{ $errors->has('index') ? ' has-error' : '' }}">
        {!! Form::label('index', __('Index'), ['class' => 'font-weight-bold']) !!}
        <span class="form-required">*</span>
        {!! Form::text('index', null, ['class' => 'form-control']) !!}
        @include('common.forms.form-error', ['key' => 'index'])
    </div>

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        {!! Form::label('name', __('Floor name'), ['class' => 'font-weight-bold']) !!}
        <span class="form-required">*</span>
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        @include('common.forms.form-error', ['key' => 'name'])
    </div>

    <div class="form-group{{ $errors->has('min_enemy_size') ? ' has-error' : '' }}">
        {!! Form::label('min_enemy_size', sprintf(__('Minimum enemy size (empty for default (%s))'), config('keystoneguru.min_enemy_size_default')), ['class' => 'font-weight-bold']) !!}
        {!! Form::number('min_enemy_size', null, ['class' => 'form-control']) !!}
        @include('common.forms.form-error', ['key' => 'min_enemy_size'])
    </div>

    <div class="form-group{{ $errors->has('max_enemy_size') ? ' has-error' : '' }}">
        {!! Form::label('max_enemy_size', sprintf(__('Maximum enemy size (empty for default (%s))'), config('keystoneguru.max_enemy_size_default')), ['class' => 'font-weight-bold']) !!}
        {!! Form::number('max_enemy_size', null, ['class' => 'form-control']) !!}
        @include('common.forms.form-error', ['key' => 'max_enemy_size'])
    </div>

    <div class="form-group{{ $errors->has('default') ? ' has-error' : '' }}">
        {!! Form::label('default', __('Default'), ['class' => 'font-weight-bold']) !!}
        <i class="fas fa-info-circle" data-toggle="tooltip" title="{{
                __('If marked as default, this floor is opened first when editing routes for this dungeon (only one should be marked as default)')
                 }}"></i>
        {!! Form::checkbox('default', 1, isset($floor) ? $floor->default : 1, ['class' => 'form-control left_checkbox']) !!}
        @include('common.forms.form-error', ['key' => 'default'])
    </div>

    @if($connectedFloorCandidates->isNotEmpty())
        {!! Form::label('connectedfloors[]', __('Connected floors'), ['class' => 'font-weight-bold']) !!}
        <i class="fas fa-info-circle" data-toggle="tooltip" title="{{
            __('A connected floor is any other floor that we may reach from this floor')
             }}"></i>

        <div class="row mb-4">
            <div class="col-2">
                {{ __('Connected') }}
            </div>
            <div class="col-8">
                {{ __('Floor name') }}
            </div>
            <div class="col-2">
                {{ __('Direction') }}
            </div>
        </div>

        <?php
        foreach($connectedFloorCandidates as $connectedFloorCandidate){
        /** @var \App\Models\FloorCoupling $floorCoupling */
        if (isset($floorCouplings)) {
            $floorCoupling = $floorCouplings->where('floor1_id', $floor->id)->where('floor2_id', $connectedFloorCandidate->id)->first();
        }
        ?>
        <div class="row mb-3">
            <div class="col-2">
                {!! Form::checkbox(sprintf('floor_%s_connected', $connectedFloorCandidate->id),
                    $connectedFloorCandidate->id, isset($floorCoupling) ? 1 : 0, ['class' => 'form-control left_checkbox']) !!}
            </div>
            <div class="col-8">
                {{ $connectedFloorCandidate->name }}
            </div>
            <div class="col-2">
                {!! Form::select(sprintf('floor_%s_direction', $connectedFloorCandidate->id), [
                            'none' => __('None'),
                            'up' => __('Up'),
                            'down' => __('Down'),
                            'left' => __('Left'),
                            'right' => __('Right')
                        ], isset($floorCoupling) ? $floorCoupling->direction : '', ['class' => 'form-control selectpicker']) !!}
            </div>
        </div>
        <?php } ?>
    @endif

    {!! Form::submit(__('Submit'), ['class' => 'btn btn-info']) !!}

    {!! Form::close() !!}
@endsection
