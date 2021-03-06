<?php
/** @var \App\Models\DungeonRoute|null $dungeonroute */

$killZonesNumberStyleChecked = ($_COOKIE['kill_zones_number_style'] ?? 'percentage') === 'percentage';
$pullsSidebarFloorSwitchVisibility = ($_COOKIE['pulls_sidebar_floor_switch_visibility'] ?? '1') === '1';
?>
<div class="pull_settings_tools container">
    <div class="form-group">
        <div class="row">
            <div class="col">
                {{ __('Pull number style') }} <i class="fas fa-info-circle" data-toggle="tooltip" title="{{
                    __('This controls how the pulls sidebar displays numbers.')
                     }}"></i>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <input id="killzones_pulls_settings_number_style" type="checkbox"
                       {{ $killZonesNumberStyleChecked ? 'checked' : '' }}
                       data-toggle="toggle" data-width="150px" data-height="20px"
                       data-onstyle="primary" data-offstyle="primary"
                       data-on="{{ __('Percentage') }}" data-off="{{ __('Enemy forces') }}">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                {{ __('Show floor breakdown') }} <i class="fas fa-info-circle" data-toggle="tooltip" title="{{
                    __('This displays the visibility of the floor breakdown in the sidebar as your pulls transition across the dungeon.')
                     }}"></i>
            </div>
        </div>
        <div class="row">
            <div class="col">
                    {!! Form::checkbox('pulls_sidebar_floor_switch_visibility', 1, $pullsSidebarFloorSwitchVisibility,
                            ['id' => 'pulls_sidebar_floor_switch_visibility', 'class' => 'form-control left_checkbox']) !!}
            </div>
        </div>
    </div>

    @if(isset($dungeonroute) && $edit)
        <div class="form-group">
            <div class="row view_dungeonroute_details_row mt-2">
                <div class="col">
                    {{ __('Pull color gradient') }} <i class="fas fa-info-circle" data-toggle="tooltip" title="{{
                    __('Setting a pull gradient will allow Keystone.guru to automatically color your pulls along a gradient.
                    Using this feature you can more easily see which pull belongs to which part of the route, useful for non-linear routes alike. This setting is unique per route.')
                     }}"></i>
                </div>
            </div>
            <div class="row view_dungeonroute_details_row mt-3">
                <div id="edit_route_freedraw_options_gradient" class="col-10">

                </div>
                <div class="col-2">
                    <button id="edit_route_freedraw_options_gradient_apply_to_pulls" class="btn btn-success"
                            data-toggle="tooltip" title="{{ __('Apply to current pulls') }}">
                        {{ __('Apply now') }}
                    </button>
                    <button id="edit_route_freedraw_options_gradient_apply_to_pulls_saving"
                            class="btn btn-success disabled"
                            style="display: none">
                        <i class='fas fa-circle-notch fa-spin'></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row no-gutters view_dungeonroute_details_row">
                <div class="col pr-2">
                    <label for="pull_gradient_apply_always">
                        {{ __('Always apply when I change pulls') }} <i class="fas fa-info-circle" data-toggle="tooltip"
                                                                        title="{{
                    __('Enabling this setting will update your pull\'s colors as you edit your pulls based on the pull gradient configured above. This setting is unique per route.')
                     }}"></i>
                    </label>
                </div>
            </div>
            <div class="row no-gutters view_dungeonroute_details_row">
                <div class="col pr-2">
                    {!! Form::checkbox('pull_gradient_apply_always', 1, $dungeonroute->pull_gradient_apply_always, ['id' => 'pull_gradient_apply_always', 'class' => 'form-control left_checkbox']) !!}
                </div>
            </div>
        </div>
    @endisset
</div>