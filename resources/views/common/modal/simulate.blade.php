<?php
/** @var $dungeonroute \App\Models\DungeonRoute\DungeonRoute|null */
/** @var bool $isThundering */
?>

@include('common.general.inline', [
    'path' => 'common/dungeonroute/simulate',
    'options' => [
        'dependencies' => ['common/maps/map'],
        'isThundering' => $isThundering
    ]
])

<h3 class="card-title">{{ __('view_common.modal.simulate.title') }}</h3>

@component('common.general.alert', ['type' => 'info', 'name' => ''])
    {{ __('view_common.modal.simulate.intro') }}
@endcomponent

@include('common.modal.simulateoptions.default', ['isThundering' => $isThundering])

@include('common.modal.simulateoptions.advanced')

<div class="form-group row">
    <div class="col">
        <div id="simulate_get_string" class="btn btn-success">
            <i class="fas fa-atom"></i> {{ __('view_common.modal.simulate.get_simulationcraft_string') }}
        </div>
    </div>
</div>

<div class="form-group">

    <div class="form-group">
        <div class="simulationcraft_export_loader_container" style="display: none;">
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">{{ __('view_common.modal.simulate.loading') }}</span>
                </div>
            </div>
        </div>
        <div class="simulationcraft_export_result_container" style="display: none;">
            <label for="simulationcraft_export_result">
                {{ __('view_common.modal.simulate.simulationcraft_string') }}
            </label>
            <textarea id="simulationcraft_export_result" class="w-100" style="height: 400px" readonly></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="simulationcraft_export_result_container" style="display: none;">
            <div class="btn btn-info copy_simulationcraft_string_to_clipboard w-100">
                <i class="far fa-copy"></i> {{ __('view_common.modal.simulate.copy_to_clipboard') }}
            </div>
        </div>
    </div>
</div>
